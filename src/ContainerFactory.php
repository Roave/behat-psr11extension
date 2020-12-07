<?php

declare(strict_types=1);

namespace Roave\BehatPsrContainer;

use Psr\Container\ContainerInterface;
use RuntimeException;

final class ContainerFactory
{
    /**
     * @throws RuntimeException
     */
    public static function createContainerFromIncludedFile(string $containerFile): ContainerInterface
    {
        /** @noinspection PhpIncludeInspection */
        $container = require $containerFile;

        if (! $container instanceof ContainerInterface) {
            throw Exception\NotAPsrContainer::fromAnythingButAPsrContainer($containerFile, $container);
        }

        return $container;
    }
}
