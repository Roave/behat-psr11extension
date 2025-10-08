<?php

declare(strict_types=1);

namespace RoaveTest\BehatPsrContainer\Exception;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Roave\BehatPsrContainer\Exception\NotAPsrContainer;
use RuntimeException;
use stdClass;

use function sprintf;
use function uniqid;

/** @covers \Roave\BehatPsrContainer\Exception\NotAPsrContainer */
final class NotAPsrContainerTest extends TestCase
{
    /** @return mixed[][] */
    public static function nonContainerValuesProvider(): array
    {
        return [
            ['just a string', 'string'],
            [42, 'integer'],
            [3.14, 'double'],
            [new stdClass(), stdClass::class],
        ];
    }

    #[DataProvider('nonContainerValuesProvider')]
    public function testExceptionForContainerValues(mixed $value, string $expectedType): void
    {
        $filename = uniqid('filename', true);

        $exception = NotAPsrContainer::fromAnythingButAPsrContainer($filename, $value);

        self::assertInstanceOf(NotAPsrContainer::class, $exception);
        self::assertInstanceOf(RuntimeException::class, $exception);
        self::assertSame(
            sprintf(
                'File %s must return a PSR-11 container, actually returned %s',
                $filename,
                $expectedType,
            ),
            $exception->getMessage(),
        );
    }
}
