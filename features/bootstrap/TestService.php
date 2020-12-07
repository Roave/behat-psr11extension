<?php
declare(strict_types=1);

namespace RoaveFeatureTest\BehatPsrContainer;

final class TestService
{
    /** @var bool */
    private $calledFromFactory;

    public function __construct(bool $calledFromFactory = false)
    {
        $this->calledFromFactory = $calledFromFactory;
    }

    public function works() : bool
    {
        return $this->calledFromFactory;
    }
}
