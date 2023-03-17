<?php

namespace Atournayre\Bundle\FixtureBundle\Provider;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

#[AutoconfigureTag(name: 'nelmio_alice.faker.provider')]
class HashPasswordProvider
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
