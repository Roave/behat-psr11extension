<?php
declare(strict_types=1);

namespace RoaveFeatureTest\BehatPsrContainer;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

final class FeatureContext implements Context
{
    /**
     * @var TestService
     */
    private $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    /**
     * @Given /^I have a Zend\\ServiceManager container$/
     */
    public function iHaveAZendServiceManagerContainer() : void
    {
    }

    /**
     * @When /^I instantiate a context$/
     */
    public function iInstantiateAContext() : void
    {
    }

    /**
     * @Then /^I should have services injected through the constructor$/
     * @throws \RuntimeException
     */
    public function iShouldHaveServicesInjected() : void
    {
        if (!$this->testService->works()) {
            throw new \RuntimeException('It didn\'t work.');
        }
    }

    /**
     * @Given /^I should have services injected as step arguments$/
     */
    public function iShouldHaveServicesInjectedAsStepArguments(TestService $testService)
    {
        if (!$testService->works()) {
            throw new \RuntimeException('It didn\'t work.');
        }
    }
}
