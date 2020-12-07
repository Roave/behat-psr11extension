<?php
declare(strict_types=1);

use RoaveFeatureTest\BehatPsrContainer\TestService;

$serviceManager = new \Zend\ServiceManager\ServiceManager();
$serviceManager->setFactory(
    TestService::class,
    static function (\Psr\Container\ContainerInterface $container) : TestService {
        return new TestService(true);
    }
);
return $serviceManager;
