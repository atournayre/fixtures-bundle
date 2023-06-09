<?php

namespace Atournayre\Bundle\FixtureBundle;

use Atournayre\Bundle\FixtureBundle\DependencyInjection\FixtureExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AtournayreFixtureBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new FixtureExtension();
        }
        return $this->extension;
    }
}
