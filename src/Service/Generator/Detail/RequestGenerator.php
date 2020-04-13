<?php

namespace App\Service\Generator\Detail;

class RequestGenerator implements DetailGeneratorInterface
{
    private const HTTP_METHODS = [
        'GET',
        'POST',
        'PATCH',
        'PUT',
        'DELETE',
    ];

    private const ALL_DIRECTORIES = [
        '/apps',
        '/pictures',
        '/videos',
        '/accounts',
        '/cars',
        '/pages',
    ];

    private const ALL_PHP_FILES = [
        '/',
        '/view.php',
        '/item.php',
        '/page.php',
        '/list.php',
        '/index.php'
    ];

    private const HTTP_VERSION = ' HTTP/1.1';

    /**
     * @throws \Exception
     */
    public function handle(): string
    {
        $method = $this->getHttpMethod();
        $requestPath = $this->getRequestPatch();

        return \sprintf('"%s %s"', $method, $requestPath);
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    private function getHttpMethod(): string
    {
        return self::HTTP_METHODS[\random_int(0, \count(self::HTTP_METHODS) - 1)];
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    private function getRequestPatch(): string
    {
        $path = '';

        for ($i = \random_int(0, 3); $i > 0; $i--) {
            $path .= self::ALL_DIRECTORIES[\random_int(0, \count(self::ALL_DIRECTORIES) - 1)];
        }

        return $path . self::ALL_PHP_FILES[\random_int(0, \count(self::ALL_PHP_FILES) - 1)] . self::HTTP_VERSION;
    }
}
