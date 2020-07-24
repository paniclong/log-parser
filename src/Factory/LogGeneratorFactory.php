<?php

namespace App\Factory;

use App\Loader\FileLoader;
use App\Service\Generator\Detail\DateGenerator;
use App\Service\Generator\Detail\IPGenerator;
use App\Service\Generator\Detail\RequestGenerator;
use App\Service\Generator\Detail\StatusGenerator;
use App\Service\Generator\Detail\TrafficGenerator;
use App\Service\Generator\Detail\UrlGenerator;
use App\Service\Generator\Detail\UserAgentGenerator;
use App\Service\Generator\LogGenerator;

class LogGeneratorFactory
{
    /**
     * @param FileLoader $fileLoader
     *
     * @return LogGenerator
     */
    public static function createWithFileLoader(FileLoader $fileLoader): LogGenerator
    {
        return new LogGenerator(
            $fileLoader,
            new IPGenerator(),
            new DateGenerator(),
            new RequestGenerator(),
            new StatusGenerator(),
            new TrafficGenerator(),
            new UrlGenerator(),
            new UserAgentGenerator()
        );
    }
}
