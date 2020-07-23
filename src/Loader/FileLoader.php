<?php

namespace App\Loader;

use App\Exception\FIleNotFoundException;
use LogicException;
use RuntimeException;
use SplFileObject;

class FileLoader implements LoaderInterface
{
    /**
     * @param string $path
     * @param string $mode
     *
     * @return SplFileObject
     *
     * @throws FIleNotFoundException
     */
    public function load(string $path, string $mode = 'rb'): SplFileObject
    {
        if (!file_exists($path)) {
            throw new FIleNotFoundException(sprintf('Can\'t resolve path - %s', $path));
        }

        /**
         * Ловим базовые исключения
         * И бросаем вверх своё кастомное
         */
        try {
            $fileObject = new SplFileObject($path, $mode);
        } catch (RuntimeException|LogicException $ex) {
            throw new FIleNotFoundException(
                $ex->getMessage(),
                $ex->getCode(),
                $ex
            );
        }

        return $fileObject;
    }

    /**
     * @todo Убрать в новый класс, либо переименовать текущий
     *
     * @param string $path
     * @param string $mode
     *
     * @return SplFileObject
     *
     * @throws FIleNotFoundException
     */
    public function create(string $path, string $mode = 'rb'): SplFileObject
    {
        $file = fopen($path, $mode);
        fclose($file);

        return $this->load($path, $mode);
    }
}
