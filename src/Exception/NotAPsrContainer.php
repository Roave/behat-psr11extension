<?php
declare(strict_types=1);

namespace Roave\BehatPsrContainer\Exception;

final class NotAPsrContainer extends \RuntimeException
{
    /**
     * @param string $filename
     * @param mixed $notAContainer
     * @return self
     */
    public static function fromAnythingButAPsrContainer(string $filename, $notAContainer) : self
    {
        return new self(sprintf(
            'File %s must return a PSR-11 container, actually returned %s',
            $filename,
            is_object($notAContainer) ? get_class($notAContainer) : gettype($notAContainer)
        ));
    }
}
