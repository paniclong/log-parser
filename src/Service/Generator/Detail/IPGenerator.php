<?php

namespace App\Service\Generator\Detail;

use Exception;

class IPGenerator implements DetailGeneratorInterface
{
    private const AVAILABLE_IPS = [
        '128.22.0.1',
        '255.255.1.1',
        '172.90.30.31',
        '51.67.123.33',
        '199.100.11.23',
        '85.89.12.10'
    ];

    /**
     * @return string
     *
     * @throws Exception
     */
    public function handle(): string
    {
        return self::AVAILABLE_IPS[\random_int(0, \count(self::AVAILABLE_IPS) - 1)];
    }
}
