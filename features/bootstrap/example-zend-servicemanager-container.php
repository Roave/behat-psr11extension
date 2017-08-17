<?php
declare(strict_types=1);

use RoaveFeatureTest\BehatPsrContainer\TestService;

$serviceManager = new \Zend\ServiceManager\ServiceManager();
$serviceManager->setService(TestService::class, new TestService());
return $serviceManager;
