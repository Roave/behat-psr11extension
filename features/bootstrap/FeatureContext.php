<?php

declare(strict_types=1);

namespace RoaveFeatureTest\BehatPsrContainer;

use Behat\Behat\Context\Context;
use RuntimeException;

final class FeatureContext implements Context
{
    public function __construct(private TestService $testService)
    {
    }

    /** @Given /^I have a Laminas\\ServiceManager container$/ */
    public function iHaveALaminasServiceManagerContainer(): void
    {
    }

    /** @When /^I instantiate a context$/ */
    public function iInstantiateAContext(): void
    {
    }

    /**
     * @throws RuntimeException
     *
     * @Then /^I should have services injected through the constructor$/
     */
    public function iShouldHaveServicesInjected(): void
    {
        if (! $this->testService->works()) {
            throw new RuntimeException('It didn\'t work.');
        }
    }

    /** @Given /^I should have services injected as step arguments$/ */
    public function iShouldHaveServicesInjectedAsStepArguments(TestService $testService): void
    {
        if (! $testService->works()) {
            throw new RuntimeException('It didn\'t work.');
        }
    }
}
