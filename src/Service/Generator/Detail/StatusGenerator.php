<?php

namespace App\Service\Generator\Detail;

use Exception;

class StatusGenerator implements DetailGeneratorInterface
{
    private const ALL_STATUSES = [
        200,
        201,
        202,
        400,
        401,
        403,
        404,
        405,
        500,
        502,
        503,
    ];

    /**
     * @return int
     *
     * @throws Exception
     */
    public function handle(): int
    {
        return self::ALL_STATUSES[random_int(0, count(self::ALL_STATUSES) - 1)];
    }
}
