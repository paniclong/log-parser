<?php

namespace App\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerFactory
{
    private const BASE_PATH = '/var/log/';

    /**
     * @param string $fileName
     *
     * @return Logger
     */
    public function create(string $fileName): Logger
    {
        $logger = new Logger('main');
        $logger->pushHandler(new StreamHandler(self::BASE_PATH . $fileName));

        return $logger;
    }
}
