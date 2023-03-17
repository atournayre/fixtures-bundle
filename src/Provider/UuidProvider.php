<?php

namespace Atournayre\Bundle\FixtureBundle\Provider;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV1;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Uid\UuidV6;
use Symfony\Component\Uid\UuidV7;

#[AutoconfigureTag(name: 'nelmio_alice.faker.provider')]
class UuidProvider
{
    public static function uuidV1(): UuidV1
    {
        return Uuid::v1();
    }

    public static function uuidV4(): UuidV4
    {
        return Uuid::v4();
    }

    public static function uuidV6(): UuidV6
    {
        return Uuid::v6();
    }

    public static function uuidV7(): UuidV7
    {
        return Uuid::v7();
    }
}
