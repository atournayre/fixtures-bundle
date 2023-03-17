<?php

namespace Atournayre\Bundle\FixtureBundle\Tests;

use Atournayre\Bundle\FixtureBundle\Provider\UuidProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\UuidV1;
use Symfony\Component\Uid\UuidV4;
use Symfony\Component\Uid\UuidV6;
use Symfony\Component\Uid\UuidV7;

class UuidTest extends TestCase
{
    public function testUuidV1(): void
    {
        $this->assertinstanceOf(UuidV1::class, UuidProvider::uuidV1());
    }

    public function testUuidV4(): void
    {
        $this->assertinstanceOf(UuidV4::class, UuidProvider::uuidV4());
    }

    public function testUuidV6(): void
    {
        $this->assertinstanceOf(UuidV6::class, UuidProvider::uuidV6());
    }

    public function testUuidV7(): void
    {
        $this->assertinstanceOf(UuidV7::class, UuidProvider::uuidV7());
    }
}
