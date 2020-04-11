<?php

namespace App\Service;

class JsonRender implements RenderInterface
{
    /**
     * @param array $data
     */
    public function view(array $data): void
    {
        echo \json_encode($data);
    }
}
