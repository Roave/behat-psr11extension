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

use function assert;
use function method_exists;
use function uniqid;

/**
 * @covers \Roave\BehatPsrContainer\PsrContainerExtension
 */
final class PsrContainerExtensionTest extends TestCase
{
    public function testPsrContainerExtensionIsABehatExtension(): void
    {
        self::assertInstanceOf(Extension::class, new PsrContainerExtension());
    }

    public function testGetConfigKeyReturnsNamespace(): void
    {
        self::assertSame('Roave\BehatPsrContainer', (new PsrContainerExtension())->getConfigKey());
    }

    public function testConfiguration(): void
    {
        $builder = new ArrayNodeDefinition('foo');

        (new PsrContainerExtension())->configure($builder);

        $node = $builder->getNode();
        assert($node instanceof ArrayNode);
        $children = $node->getChildren();
        self::assertCount(2, $children);

        self::assertArrayHasKey('container', $children);
        $containerNode = $children['container'];
        assert($containerNode instanceof ScalarNode);
        self::assertSame('config/container.php', $containerNode->getDefaultValue());

        self::assertArrayHasKey('name', $children);
        $nameNode = $children['name'];
        assert($nameNode instanceof ScalarNode);
        self::assertSame('psr_container', $nameNode->getDefaultValue());
    }

    public function testLoadSetsUpContainer(): void
    {
        $builder              = new ContainerBuilder();
        $containerConfigValue = uniqid('containerConfigvalue', true);
        $nameConfigValue      = uniqid('nameConfigValue', true);

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

        if ($sharedOrScopeTested) {
            return;
        }

        self::fail('Expected to have assertion on isShared or getScope method, but neither existed');
    }
}
