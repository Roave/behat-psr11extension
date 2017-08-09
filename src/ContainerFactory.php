<?php
declare(strict_types=1);

namespace Roave\BehatPsrContainer;

use Psr\Container\ContainerInterface;

final class ContainerFactory
{
    /**
     * @param string $containerFile
     * @return ContainerInterface
     * @throws \RuntimeException
     */
    public static function createContainerFromIncludedFile(string $containerFile) : ContainerInterface
    {
        /** @noinspection PhpIncludeInspection */
        $container = require $containerFile;

        if (!$container instanceof ContainerInterface) {
            throw new \RuntimeException(sprintf('File %s must return a PSR-11 container', $containerFile));
        }

        return $container;
    }
}
