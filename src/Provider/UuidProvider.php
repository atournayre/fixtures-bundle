<?php

namespace Atournayre\Bundle\FixtureBundle\Provider;

use Atournayre\Bundle\FixtureBundle\Contracts\FixtureProvider;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV1;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Uid\UuidV6;
use Symfony\Component\Uid\UuidV7;

class UuidProvider implements FixtureProvider
{
    public static function uuidV1(): UuidV1
    {
        return Uuid::v1();
    }

    public static function uuidV4(?string $uuid = null): UuidV4
    {
        if (is_null($uuid)) {
            return Uuid::v4();
        }

        return UuidV4::fromString($uuid);
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
