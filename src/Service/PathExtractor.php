<?php

namespace App\Service;

use App\Exception\ArgumentNotFoundException;

class PathExtractor
{
    /**
     * Номер аргумента, в котором находиться путь к лог файлу
     */
    private const PATH_ARGUMENT = 1;

    /**
     * @param array $arguments
     *
     * @return string
     *
     * @throws ArgumentNotFoundException
     */
    public function get(array $arguments): string
    {
        if (!isset($arguments[self::PATH_ARGUMENT]) || empty($arguments[self::PATH_ARGUMENT])) {
            throw new ArgumentNotFoundException('Invalid Argument');
        }

        return $arguments[self::PATH_ARGUMENT];
    }
}
