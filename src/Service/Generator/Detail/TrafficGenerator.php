<?php

namespace App\Service\Generator\Detail;

class TrafficGenerator implements DetailGeneratorInterface
{
    private const MAX_TRAFFIC = 100000;

    /**
     * @return int
     *
     * @throws \Exception
     */
    public function handle(): int
    {
        return \random_int(0, self::MAX_TRAFFIC);
    }
}
