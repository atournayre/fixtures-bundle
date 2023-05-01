<?php

namespace Atournayre\Bundle\FixtureBundle\Event;

use Symfony\Component\Console\Style\SymfonyStyle;

class BeforeFixturesEvent
{
    public function __construct(
        public SymfonyStyle $io,
    )
    {
    }
}
