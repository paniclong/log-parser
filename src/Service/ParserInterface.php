<?php

namespace App\Service;

use App\Exception\FailParserException;
use SplFileObject;

interface ParserInterface
{
    /**
     * @param SplFileObject $fileObject
     *
     * @return array
     *
     * @throws FailParserException
     */
    public function handle(SplFileObject $fileObject): array;
}
