<?php
// @todo Расписать как работает процесс парсинга
// @todo Расписать как работает процесс rollback'а записей

use App\Exception\ArgumentNotFoundException;
use App\Exception\RuntimeException;
use App\Factory\EntryPointFactory;
use App\Factory\LogGeneratorFactory;
use App\Factory\LoggerFactory;
use App\Loader\FileLoader;

require_once 'vendor/autoload.php';

try {
    $extractor = new App\Service\ArgumentsExtractor($argv);
    $fileLoader = new FileLoader();

    $command = $extractor->getCommand();

    if (in_array($command, ['log-create', 'log-update', 'log-rollback'], true)) {
        $generator = LogGeneratorFactory::createWithFileLoader($fileLoader);

        $countRecords = 100;
        try {
            $countRecords = $extractor->getCount();
        } catch (ArgumentNotFoundException $ex) {
        }

        switch ($command) {
            case 'log-create':
                $generator->create($countRecords);
                break;
            case 'log-update':
                $pathToDummyFile = $extractor->getPathForDummyFile();

                $generator->update($pathToDummyFile, $countRecords);
                break;
            case 'log-rollback':
                $pathToDummyFile = $extractor->getPathForDummyFile();

                $generator->rollback($pathToDummyFile, $countRecords);
                break;
            default:
                throw new RuntimeException(sprintf('Unknown command - %s', $command));
        }

        return;
    }

    EntryPointFactory::createWithFileLoader($fileLoader)
        ->read($extractor->getPath())
        ->parse();
} catch (Throwable $ex) {
    $logger = (new LoggerFactory())->create('main.log');

    $logger->critical($ex->getMessage(), ['traceAsString' => $ex->getTraceAsString()]);

    echo 'Что-то пошло не так, смотри логи' . PHP_EOL;
}
