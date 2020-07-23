<?php

namespace App\Service\Generator\Detail;

use Exception;

class UserAgentGenerator implements DetailGeneratorInterface
{
    private const ALL_USER_AGENT = [
        'Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0',
        'Mozilla/5.0 (Windows NT 6.1; WOW64) Googlebot/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31',
        'Mozilla/5.0 (Windows NT 6.1; WOW64) Yandexbot/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31',
        'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31',
        'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36',
        'Mozilla/5.0 (X11; Linux x86_64) Bingbot/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36',
        'Mozilla/5.0 (X11; Linux x86_64) Baidubot/537.36 (KHTML, like Gecko) Chrome/80.0.3987.163 Safari/537.36',
    ];

    /**
     * @return string
     *
     * @throws Exception
     */
    public function handle(): string
    {
        return sprintf('"%s"', self::ALL_USER_AGENT[random_int(0, count(self::ALL_USER_AGENT) - 1)]);
    }
}
