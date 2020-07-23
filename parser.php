<?php

use App\Exception\ArgumentNotFoundException;
use App\Exception\FailParserException;
use App\Exception\FIleNotFoundException;
use App\Exception\RuntimeException;
use App\Factory\EntryPointFactory;
use App\Factory\LogGeneratorFactory;
use App\Loader\FileLoader;
use App\Service\PathExtractor;

require_once 'vendor/autoload.php';

if (count($argv) === 1) {
    echo 'Not enough arguments' . PHP_EOL;

    return;
}

$fileLoader = new FileLoader();

if (
    isset($argv[1])
    && in_array($argv[1], ['log-create', 'log-update', 'log-rollback'], true)
) {
    try {
        $generator = LogGeneratorFactory::createWithFileLoader($fileLoader);

        if (isset($argv[2]) && is_numeric($argv[2])) {
            $countRecords = (int)$argv[2];
        }

        switch ($argv[1]) {
            case 'log-create':
                $generator->create($argv[2] ?? 100);
                break;
            case 'log-update':
                $path = $argv[3] ?? '';
                $count = $argv[2] ?? 100;

                $generator->update($path, $count);
                break;
            case 'log-rollback':
                $path = $argv[3] ?? '';
                $count = $argv[2] ?? 1;

                $generator->rollback($path, $count);
                break;
            default:
                throw new RuntimeException('Unknown action');
        }
    } catch (Exception $ex) {
        echo $ex->getMessage() . PHP_EOL;
    }

    return;
}

try {
    $entryPoint = EntryPointFactory::createWithFileLoader($fileLoader);

    $entryPoint
        ->read((new PathExtractor())->get($argv))
        ->parse();
} catch (ArgumentNotFoundException $ex) {
    echo $ex->getMessage(). PHP_EOL;
} catch (FIleNotFoundException $ex) {
    echo $ex->getMessage(). PHP_EOL;
} catch (FailParserException $ex) {
    echo $ex->getMessage(). PHP_EOL;
}
