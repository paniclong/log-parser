<?php

namespace App\Loader;

use App\Exception\FIleNotFoundException;

interface LoaderInterface
{
    /**
     * @param string $path
     * @param string $mode
     *
     * @return mixed
     *
     * @throws FIleNotFoundException
     */
    public function load(string $path, string $mode = 'r');
}
