<?php

require_once 'vendor/autoload.php';

$pathExtractor = new \App\Service\PathExtractor();
$fileLoader = new \App\Loader\FileLoader();

$validator = new \App\Service\ArgumentValidator();
$parser = new \App\Service\Parser($validator);

$render = new \App\Service\JsonRender();

$entryPoint = new \App\EntryPoint(
    $fileLoader,
    $parser,
    $render
);

try {
    $entryPoint->read($pathExtractor->get($argv));
    $entryPoint->parse();
} catch (\App\Exception\ArgumentNotFoundException $ex) {
    echo $ex->getMessage();
} catch (\App\Exception\FIleNotFoundException $ex) {
    echo $ex->getMessage();
} catch (\App\Exception\FailParserException $ex) {
    echo $ex->getMessage();
}
