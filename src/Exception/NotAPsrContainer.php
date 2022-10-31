<?php

declare(strict_types=1);

namespace Roave\BehatPsrContainer\Exception;

use RuntimeException;

use function gettype;
use function is_object;
use function sprintf;

final class NotAPsrContainer extends RuntimeException
{
    public static function fromAnythingButAPsrContainer(string $filename, mixed $notAContainer): self
    {
        return new self(sprintf(
            'File %s must return a PSR-11 container, actually returned %s',
            $filename,
            is_object($notAContainer) ? $notAContainer::class : gettype($notAContainer),
        ));
    }
}
