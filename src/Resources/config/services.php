<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Atournayre\Bundle\FixtureBundle\Contracts\FixtureProvider;
use Atournayre\Bundle\FixtureBundle\Provider\DateTimeProvider;
use Atournayre\Bundle\FixtureBundle\Provider\EntityProvider;
use Atournayre\Bundle\FixtureBundle\Provider\HashPasswordProvider;
use Atournayre\Bundle\FixtureBundle\Provider\UuidProvider;

return static function (ContainerConfigurator $container) {
    $tagNelmioAliceFakerProvider = 'nelmio_alice.faker.provider';

    $services = $container->services()
        ->defaults()
        ->instanceof(FixtureProvider::class)->tag($tagNelmioAliceFakerProvider);

    $fixturesProviders = [
        DateTimeProvider::class,
        EntityProvider::class,
        HashPasswordProvider::class,
        UuidProvider::class,
    ];

    foreach ($fixturesProviders as $fixturesProvider) {
        $services->set($fixturesProvider)->autowire()->public();
    }
};
