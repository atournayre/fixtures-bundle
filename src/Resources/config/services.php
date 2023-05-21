<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Atournayre\Bundle\FixtureBundle\Command\FixturesCommand;
use Atournayre\Bundle\FixtureBundle\Contracts\FixtureProvider;
use Atournayre\Bundle\FixtureBundle\Provider\DateTimeProvider;
use Atournayre\Bundle\FixtureBundle\Provider\EntityProvider;
use Atournayre\Bundle\FixtureBundle\Provider\HashPasswordProvider;
use Atournayre\Bundle\FixtureBundle\Provider\UuidProvider;

return static function (ContainerConfigurator $container) {
    $tagNelmioAliceFakerProvider = 'nelmio_alice.faker.provider';

    $services = $container->services()
        ->defaults()->private()
        ->instanceof(FixtureProvider::class)->tag($tagNelmioAliceFakerProvider);

    $services->set(FixturesCommand::class)->public()
        ->arg(0, service('kernel'))
        ->arg(1, service('service_container'))
        ->arg(2, service('event_dispatcher'))
        ->arg(3, service('doctrine'))
        ->arg(4, service('hautelook_alice.loader'))
        ->arg(5, FixturesCommand::NAME)
        ->tag('console.command');

    $fixturesProviders = [
        DateTimeProvider::class,
        EntityProvider::class,
        HashPasswordProvider::class,
        UuidProvider::class,
    ];

    foreach ($fixturesProviders as $fixturesProvider) {
        $services->set($fixturesProvider)->public()
            ->autowire();
    }
};
