<?php
declare(strict_types=1);

namespace RoaveTest\BehatPsrContainer;

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
    public function iHaveAZendServiceManagerContainer()
    {
    }

    /**
     * @When /^I instantiate a context$/
     */
    public function iInstantiateAContext()
    {
    }

    /**
     * @Then /^I should have services injected$/
     * @throws \RuntimeException
     */
    public function iShouldHaveServicesInjected()
    {
        if (!$this->testService->works()) {
            throw new \RuntimeException('It didn\'t work.');
        }
    }
}
