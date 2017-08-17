<?php
declare(strict_types=1);

namespace RoaveTest\BehatPsrContainer;

use Behat\Testwork\ServiceContainer\Extension;
use PHPUnit\Framework\TestCase;
use Roave\BehatPsrContainer\ContainerFactory;
use Roave\BehatPsrContainer\PsrContainerExtension;
use Symfony\Component\Config\Definition\ArrayNode;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ScalarNode;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @covers \Roave\BehatPsrContainer\PsrContainerExtension
 */
final class PsrContainerExtensionTest extends TestCase
{
    public function testPsrContainerExtensionIsABehatExtension()
    {
        self::assertInstanceOf(Extension::class, new PsrContainerExtension());
    }

    public function testGetConfigKeyReturnsNamespace()
    {
        self::assertSame('Roave\BehatPsrContainer', (new PsrContainerExtension())->getConfigKey());
    }

    public function testConfiguration()
    {
        $builder = new ArrayNodeDefinition('foo');

        (new PsrContainerExtension())->configure($builder);

        /** @var ArrayNode $node */
        $node = $builder->getNode();
        $children = $node->getChildren();
        self::assertCount(2, $children);

        self::assertArrayHasKey('container', $children);
        /** @var ScalarNode $containerNode */
        $containerNode = $children['container'];
        self::assertSame('config/container.php', $containerNode->getDefaultValue());

        self::assertArrayHasKey('name', $children);
        /** @var ScalarNode $nameNode */
        $nameNode = $children['name'];
        self::assertSame('psr_container', $nameNode->getDefaultValue());
    }

    public function testLoadSetsUpContainer()
    {
        $builder = new ContainerBuilder();
        $containerConfigValue = uniqid('containerConfigvalue', true);
        $nameConfigValue = uniqid('nameConfigValue', true);

        (new PsrContainerExtension())->load(
            $builder,
            [
                'container' => $containerConfigValue,
                'name' => $nameConfigValue,
            ]
        );

        self::assertSame($containerConfigValue, $builder->getParameter('roave.behat.psr.container.included.file'));

        self::assertTrue($builder->hasDefinition($nameConfigValue));
        $definition = $builder->getDefinition($nameConfigValue);
        self::assertSame([ContainerFactory::class, 'createContainerFromIncludedFile'], $definition->getFactory());
        self::assertSame(['helper_container.container' => [[]]], $definition->getTags());

        $sharedOrScopeTested = false;

        if (method_exists($definition, 'isShared')) {
            $sharedOrScopeTested = true;
            self::assertFalse($definition->isShared());
        }

        if (method_exists($definition, 'getScope')) {
            $sharedOrScopeTested = true;
            self::assertSame(ContainerBuilder::SCOPE_PROTOTYPE, $definition->getScope());
        }

        if (!$sharedOrScopeTested) {
            self::fail('Expected to have assertion on isShared or getScope method, but neither existed');
        }
    }
}
