<?php

namespace Atournayre\Bundle\FixtureBundle\Event;

use Symfony\Component\Console\Style\SymfonyStyle;

class AfterFixturesEvent
{
    public function __construct(
        public SymfonyStyle $io,
        public string $memoryLimit,
    )
    {
    }
}
