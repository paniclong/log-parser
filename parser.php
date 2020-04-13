<?php

require_once 'vendor/autoload.php';

$fileLoader = new \App\Loader\FileLoader();

if ($argv[1] === 'app:generate-log') {
    $generator = new \App\Service\Generator\LogGenerator(
        $fileLoader,
        new \App\Service\Generator\Detail\IPGenerator,
        new \App\Service\Generator\Detail\DateGenerator,
        new \App\Service\Generator\Detail\RequestGenerator,
        new \App\Service\Generator\Detail\StatusGenerator,
        new \App\Service\Generator\Detail\TrafficGenerator,
        new \App\Service\Generator\Detail\UrlGenerator,
        new \App\Service\Generator\Detail\UserAgentGenerator
    );

    try {
        if (isset($argv[2])) {
            switch ($argv[2]) {
                case 'create': $generator->create($argv[3] ?? 100);break;
                case 'update': $generator->update($argv[3] ?? '', $argv[4] ?? 100);break;
                case 'rollback': $generator->rollback($argv[3] ?? '', $argv[4] ?? 1);break;
                default:
                    throw new \App\Exception\RuntimeException('Method not set');
            }
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }

    return;
}

$entryPoint = new \App\EntryPoint(
    $fileLoader,
    new \App\Service\Parser(
        new \App\Service\ArgumentValidator()
    ),
    new \App\Service\JsonRender()
);

try {
    $entryPoint->read((new \App\Service\PathExtractor())->get($argv));
    $entryPoint->parse();
} catch (\App\Exception\ArgumentNotFoundException $ex) {
    echo $ex->getMessage();
} catch (\App\Exception\FIleNotFoundException $ex) {
    echo $ex->getMessage();
} catch (\App\Exception\FailParserException $ex) {
    echo $ex->getMessage();
}
