<?php
declare(strict_types=1);

namespace RoaveTest\BehatPsrContainer;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Roave\BehatPsrContainer\ContainerFactory;

/**
 * @covers \Roave\BehatPsrContainer\ContainerFactory
 */
final class ContainerFactoryTest extends TestCase
{
    /**
     * @var string
     */
    private $tempFilename;

    public function setUp() : void
    {
        $this->tempFilename = tempnam(sys_get_temp_dir(), str_replace('\\', '_', __CLASS__) . '_');
    }

    public function tearDown() : void
    {
        if (file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }
    }

    public function testFactoryThrowsExceptionWhenFileDoesNotReturnContainer() : void
    {
        file_put_contents(
            $this->tempFilename,
            "<?php return new \stdClass();"
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('File ' . $this->tempFilename . ' must return a PSR-11 container');
        ContainerFactory::createContainerFromIncludedFile($this->tempFilename);
    }

    public function testFactoryReturnsContainerIfIncluded() : void
    {
        file_put_contents(
            $this->tempFilename,
            '<?php return new class implements \Psr\Container\ContainerInterface {
                public function get($id) {}
                public function has($id) {}
            };'
        );

        $container = ContainerFactory::createContainerFromIncludedFile($this->tempFilename);
        self::assertInstanceOf(ContainerInterface::class, $container);
    }
}
