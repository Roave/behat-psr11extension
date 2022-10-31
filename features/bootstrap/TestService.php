<?php

declare(strict_types=1);

namespace RoaveFeatureTest\BehatPsrContainer;

final class TestService
{
    public function __construct(private bool $calledFromFactory = false)
    {
    }

    public function works(): bool
    {
        return $this->calledFromFactory;
    }
}
