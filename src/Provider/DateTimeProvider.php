<?php

namespace Atournayre\Bundle\FixtureBundle\Provider;

use Atournayre\Bundle\FixtureBundle\Contracts\FixtureProvider;

class DateTimeProvider implements FixtureProvider
{
    public function currentDateWithTime(string $time): ?\DateTimeInterface
    {
        /** @var int[] $times */
        $times = explode(':', $time);

        return (new \DateTime())
            ->setTime(...$times);
    }

    public function randomHourWithDate(): ?\DateTimeInterface
    {
        $hours = range(0, 23);
        $hour = array_rand($hours);

        return (new \DateTime())
            ->setTime($hour, 0);
    }
}
