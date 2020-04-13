<?php

namespace App\Service\Generator\Detail;

class UrlGenerator implements DetailGeneratorInterface
{
    private const ALL_DOMAIN = [
        'http://example.com/',
        'https://yandex.ru/',
        'https://php.com/',
        'https://test.su/',
        'http://darknet.ua/',
        'http://allrocks.ru/',
    ];

    /**
     * @return string
     *
     * @throws \Exception
     */
    public function handle(): string
    {
        return \sprintf('"%s"', self::ALL_DOMAIN[\random_int(0, \count(self::ALL_DOMAIN) - 1)]);
    }
}
