<?php

namespace App\Service;

interface ParserInterface
{
    /**
     * @param \SplFileObject $fileObject
     *
     * @return array
     */
    public function handle(\SplFileObject $fileObject): array;
}
