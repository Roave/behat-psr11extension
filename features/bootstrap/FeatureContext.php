<?php
declare(strict_types=1);

namespace RoaveFeatureTest\BehatPsrContainer;

use Behat\Behat\Context\Context;

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
     * @Then /^I should have services injected$/
     * @throws \RuntimeException
     */
    public function iShouldHaveServicesInjected() : void
    {
        if (!$this->testService->works()) {
            throw new \RuntimeException('It didn\'t work.');
        }
    }
}
