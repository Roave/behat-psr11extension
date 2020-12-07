<?php

declare(strict_types=1);

namespace Roave\BehatPsrContainer\Exception;

use RuntimeException;

use function get_class;
use function gettype;
use function is_object;
use function sprintf;

final class NotAPsrContainer extends RuntimeException
{
    /**
     * @param mixed $notAContainer
     */
    public static function fromAnythingButAPsrContainer(string $filename, $notAContainer): self
    {
        return new self(sprintf(
            'File %s must return a PSR-11 container, actually returned %s',
            $filename,
            is_object($notAContainer) ? get_class($notAContainer) : gettype($notAContainer)
        ));
    }
}
