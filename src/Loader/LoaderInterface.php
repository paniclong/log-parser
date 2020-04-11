<?php

namespace App\Loader;

use App\Exception\FIleNotFoundException;

interface LoaderInterface
{
    /**
     * @param string $path
     *
     * @return mixed
     *
     * @throws FIleNotFoundException
     */
    public function load(string $path);
}
