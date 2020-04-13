<?php

namespace App\Service\Generator;

use App\Loader\FileLoader;
use App\Service\Generator\Detail\DateGenerator;
use App\Service\Generator\Detail\IPGenerator;
use App\Service\Generator\Detail\RequestGenerator;
use App\Service\Generator\Detail\StatusGenerator;
use App\Service\Generator\Detail\TrafficGenerator;
use App\Service\Generator\Detail\UrlGenerator;
use App\Service\Generator\Detail\UserAgentGenerator;

class LogGenerator
{
    /**
     * @var FileLoader
     */
    private $fileLoader;

    /**
     * @var IPGenerator
     */
    private $IPGenerator;

    /**
     * @var DateGenerator
     */
    private $dateGenerator;

    /**
     * @var RequestGenerator
     */
    private $requestGenerator;

    /**
     * @var StatusGenerator
     */
    private $statusGenerator;

    /**
     * @var TrafficGenerator
     */
    private $trafficGenerator;

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    /**
     * @var UserAgentGenerator
     */
    private $userAgentGenerator;

    /**
     * @param FileLoader $fileLoader
     * @param IPGenerator $IPGenerator
     * @param DateGenerator $dateGenerator
     * @param RequestGenerator $requestGenerator
     * @param StatusGenerator $statusGenerator
     * @param TrafficGenerator $trafficGenerator
     * @param UrlGenerator $urlGenerator
     * @param UserAgentGenerator $userAgentGenerator
     */
    public function __construct(
        FileLoader $fileLoader,
        IPGenerator $IPGenerator,
        DateGenerator $dateGenerator,
        RequestGenerator $requestGenerator,
        StatusGenerator $statusGenerator,
        TrafficGenerator $trafficGenerator,
        UrlGenerator $urlGenerator,
        UserAgentGenerator $userAgentGenerator
    ) {
        $this->fileLoader = $fileLoader;
        $this->IPGenerator = $IPGenerator;
        $this->dateGenerator = $dateGenerator;
        $this->requestGenerator = $requestGenerator;
        $this->statusGenerator = $statusGenerator;
        $this->trafficGenerator = $trafficGenerator;
        $this->urlGenerator = $urlGenerator;
        $this->userAgentGenerator = $userAgentGenerator;
    }

    /**
     * Создаем "эмуляцию" файла access.log nginx'а
     *
     * @param int $attempt
     *
     * @throws \Exception
     */
    public function create(int $attempt = 100): void
    {
        $file = $this->fileLoader->load(
            \sprintf(__DIR__ . '/../../../files/access%s.log', \time()),
            'wb'
        );

        for ($i = $attempt; $i > 0; $i--) {
            $file->fwrite($this->generateRecord());
        }

        $file = null;
    }

    /**
     * Добавляем в файле n количество записей
     *
     * @param string $path      Путь к файлу
     * @param int    $attempt   На сколько необходимо добавить
     *
     * @throws \Exception
     */
    public function update(string $path, int $attempt = 100): void
    {
        $file = $this->fileLoader->load($path, 'ab');

        for ($i = $attempt; $i > 0; $i--) {
            $file->fwrite($this->generateRecord());
        }

        $file = null;
    }

    /**
     * Откатываем на N-е количество записей
     *
     * @param string $path      Путь к файлу
     * @param int    $countRow  На сколько необходимо откатить
     *
     * @throws \App\Exception\FIleNotFoundException
     */
    public function rollback(string $path, int $countRow = 1): void
    {
        $file = $this->fileLoader->load($path, 'rwb+');

        $bytes = -2;
        $line = 0;

        $file->fseek($bytes, SEEK_END);

        for (;;) {
            $file->fseek($bytes, SEEK_END);

            if ($file->fgetc() === "\n") {
                $line++;
            }

            if ($countRow === $line) {
                break;
            }

            if ($file->ftell() <= 1) {
                break;
            }

            $bytes--;
        }

        $file->rewind();
        $file->ftruncate($file->ftell());

        $file = null;
    }

    /**
     * @return string
     *
     * @throws \Exception
     */
    private function generateRecord(): string
    {
        return \sprintf(
                '%s - - %s %s %s %s %s %s',
                $this->IPGenerator->handle(),
                $this->dateGenerator->handle(),
                $this->requestGenerator->handle(),
                $this->statusGenerator->handle(),
                $this->trafficGenerator->handle(),
                $this->urlGenerator->handle(),
                $this->userAgentGenerator->handle()
            ) . PHP_EOL;
    }
}
