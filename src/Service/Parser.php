<?php

namespace App\Service;

use App\Exception\FailParserException;
use SplFileObject;

class Parser implements ParserInterface
{
    /**
     * Типы ботов
     */
    public const ALL_CRAWLERS = [
        'Google' => 'Googlebot',
        'Bing' => 'Bingbot',
        'Baidu' => 'Baidubot',
        'Yandex' => 'Yandexbot',
    ];

    /**
     * Позиция статус кода, которая соотвествует ключу массива
     */
    public const ARGUMENT_STATUS_CODE = 8;

    /**
     * Позиция трафика, которая соотвествует ключу массива
     */
    public const ARGUMENT_TRAFFIC = 9;

    /**
     * Позиция url, которая соотвествует ключу массива
     */
    public const ARGUMENT_URL = 10;

    /**
     * Стартовое значение, если в массиве не найден нужный ключ
     */
    private const START_VALUE = 1;

    /**
     * Количество запросов с url, которое мы считаем уникальным
     */
    private const COUNT_UNIQUE_URL = 1;

    /**
     * Количество неуспешных попыток валидации,
     * если больше или равно то бросается исключение FailParserException
     */
    private const COUNT_FAIL_ATTEMPT = 10;

    /**
     * @var ArgumentValidator
     */
    private $validator;

    /**
     * @param ArgumentValidator $validator
     */
    public function __construct(ArgumentValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Данным метод парсит лог файл и возвращает следующую информацию:
     *
     * Общее кол-во просмотров(запросов) ($views)
     * Кол-во уникальный url ($urls)
     * Общее кол-во траффика ($traffic)
     * Кол-во кодов ответа, сгруппированных по типу ($statusCodes)
     * Кол-во ботов(crawlers), сгруппированных по типу ($crawlers)
     *
     * Пример:
     *  array(5) {
     *      ["views"]=>
     *          int(17)
     *      ["traffic"]=>
     *          int(259358)
     *      ["urls"]=>
     *          array(1) {
     *              ["http://bim-bom.ru/"]=>
     *                  int(1)
     *              }
     *      ["crawlers"]=>
     *          array(2) {
     *              ["Google"]=>
     *                  int(2)
     *              ["Yandex"]=>
     *                  int(1)
     *          }
     *      ["statusCodes"]=>
     *          array(2) {
     *              [200]=>
     *                  int(15)
     *              [301]=>
     *                  int(2)
     *          }
     *  }
     *
     * @param SplFileObject $fileObject
     *
     * @return array
     *
     * @throws FailParserException
     */
    public function handle(SplFileObject $fileObject): array
    {
        $failAttempt = 0;

        $views = 0;
        $maybeUniqueUrls = [];
        $traffic = 0;
        $statusCodes = [];
        $crawlers = [];

        while (!$fileObject->eof()) {
            if ($failAttempt >= self::COUNT_FAIL_ATTEMPT) {
                throw new FailParserException(
                    sprintf(
                        'Not successful parser work, with fail attempt more %d times',
                        self::COUNT_FAIL_ATTEMPT
                    )
                );
            }
            $line = $fileObject->fgets();

            $logArguments = explode(' ', $line);

            if (!$this->validator->validate($logArguments)) {
                $failAttempt++;

                continue;
            }

            $rawUrl = trim($logArguments[self::ARGUMENT_URL], '"');
            $rawCode = $logArguments[self::ARGUMENT_STATUS_CODE];

            $maybeUniqueUrls[$rawUrl] = isset($maybeUniqueUrls[$rawUrl])
                ? ++$maybeUniqueUrls[$rawUrl]
                : self::START_VALUE;

            $statusCodes[$rawCode] = isset($statusCodes[$rawCode]) ? ++$statusCodes[$rawCode] : self::START_VALUE;

            foreach (self::ALL_CRAWLERS as $key => $crawler) {
                if (\strpos($line, $crawler) !== false) {
                    if (isset($crawlers[$key])) {
                        $crawlers[$key]++;

                        continue;
                    }

                    $crawlers[$key] = self::START_VALUE;
                }
            }

            $traffic += $logArguments[self::ARGUMENT_TRAFFIC];
            $views++;
        }

        $urls = 0;
        foreach ($maybeUniqueUrls as $key => $count) {
            if ($count > self::COUNT_UNIQUE_URL) {
                unset($maybeUniqueUrls[$key]);

                continue;
            }

            $urls++;
        }

        return compact('views', 'traffic', 'urls', 'crawlers', 'statusCodes');
    }
}
