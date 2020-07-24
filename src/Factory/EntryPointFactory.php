<?php

namespace App\Factory;

use App\EntryPoint;
use App\Loader\FileLoader;
use App\Service\ArgumentValidator;
use App\Service\JsonRender;
use App\Service\Parser;

class EntryPointFactory
{
    /**
     * @param FileLoader $fileLoader
     *
     * @return EntryPoint
     */
    public static function createWithFileLoader(FileLoader $fileLoader): EntryPoint
    {
        return new EntryPoint($fileLoader, new Parser(new ArgumentValidator()), new JsonRender());
    }
}
