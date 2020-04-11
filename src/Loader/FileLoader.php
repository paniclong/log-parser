<?php

namespace App\Loader;

use App\Exception\FIleNotFoundException;

class FileLoader implements LoaderInterface
{
    /**
     * @param string $path
     *
     * @return \SplFileObject
     *
     * @throws FIleNotFoundException
     */
    public function load(string $path): \SplFileObject
    {
        /**
         * Ловим базовые исключения
         * И бросаем вверх своё кастомное
         */
        try {
            $fileObject = new \SplFileObject($path);
        } catch (\RuntimeException|\LogicException $ex) {
            throw new FIleNotFoundException(
                $ex->getMessage(),
                $ex->getCode(),
                $ex
            );
        }

        return $fileObject;
    }
}
