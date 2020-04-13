<?php

namespace App\Loader;

use App\Exception\FIleNotFoundException;

class FileLoader implements LoaderInterface
{
    /**
     * @param string $path
     * @param string $mode
     *
     * @return \SplFileObject
     *
     * @throws FIleNotFoundException
     */
    public function load(string $path, string $mode = 'r'): \SplFileObject
    {
        /**
         * Ловим базовые исключения
         * И бросаем вверх своё кастомное
         */
        try {
            $fileObject = new \SplFileObject($path, $mode);
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
