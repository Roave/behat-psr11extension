<?php

declare(strict_types=1);

namespace RoaveTest\BehatPsrContainer;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Roave\BehatPsrContainer\ContainerFactory;
use Roave\BehatPsrContainer\Exception\NotAPsrContainer;

use function file_exists;
use function file_put_contents;
use function str_replace;
use function sys_get_temp_dir;
use function tempnam;
use function unlink;

/**
 * @covers \Roave\BehatPsrContainer\ContainerFactory
 */
final class ContainerFactoryTest extends TestCase
{
    private string $tempFilename;

    public function setUp(): void
    {
        $this->tempFilename = tempnam(sys_get_temp_dir(), str_replace('\\', '_', self::class) . '_');
    }

    public function tearDown(): void
    {
        if (! file_exists($this->tempFilename)) {
            return;
        }

        unlink($this->tempFilename);
    }

    public function testFactoryThrowsExceptionWhenFileDoesNotReturnContainer(): void
    {
        file_put_contents(
            $this->tempFilename,
            '<?php return new \stdClass();'
        );

        $this->expectException(NotAPsrContainer::class);
        ContainerFactory::createContainerFromIncludedFile($this->tempFilename);
    }

    public function testFactoryReturnsContainerIfIncluded(): void
    {
        file_put_contents(
            $this->tempFilename,
            '<?php return new class implements \Psr\Container\ContainerInterface {
                public function get(string $id):bool {}
                public function has(string $id):bool {}
            };'
        );

        $container = ContainerFactory::createContainerFromIncludedFile($this->tempFilename);
        self::assertInstanceOf(ContainerInterface::class, $container);
    }
}
