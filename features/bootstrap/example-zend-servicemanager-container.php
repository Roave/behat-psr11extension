<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use RoaveFeatureTest\BehatPsrContainer\TestService;
use Zend\ServiceManager\ServiceManager;

$serviceManager = new ServiceManager();
$serviceManager->setFactory(
    TestService::class,
    static function (ContainerInterface $container): TestService {
        return new TestService(true);
    }
);

return $serviceManager;
