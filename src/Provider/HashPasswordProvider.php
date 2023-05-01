<?php

namespace Atournayre\Bundle\FixtureBundle\Provider;

use Atournayre\Bundle\FixtureBundle\Contracts\FixtureProvider;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class HashPasswordProvider implements FixtureProvider
{
    public function __construct(
        private readonly PasswordHasherFactoryInterface $passwordHasherFactory,
    )
    {
    }

    public function hashPassword(string $plainPassword): string
    {
        return $this->passwordHasherFactory->getPasswordHasher('')
            ->hash($plainPassword);
    }
}
