<?php

namespace App;

use App\Loader\LoaderInterface;
use App\Service\Parser;
use App\Service\RenderInterface;

class EntryPoint
{
    /**
     * @var LoaderInterface
     */
    private $loader;

    /**
     * @var \SplFileObject
     */
    private $fileObject;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var RenderInterface
     */
    private $render;

    /**
     * @param LoaderInterface $loader
     * @param Parser $parser
     * @param RenderInterface $render
     */
    public function __construct(LoaderInterface $loader, Parser $parser, RenderInterface $render)
    {
        $this->loader = $loader;
        $this->parser = $parser;
        $this->render = $render;
    }

    /**
     * @param string $path
     *
     * @throws Exception\FIleNotFoundException
     */
    public function read(string $path): void
    {
        $this->fileObject = $this->loader->load($path);
    }

    /**
     * @throws Exception\FailParserException
     */
    public function parse(): void
    {
        $this->render->view(
            $this->parser->handle($this->fileObject)
        );
    }

    /**
     * Закрываем дескриптор файла
     */
    public function __destruct()
    {
        $this->fileObject = null;
    }
}
