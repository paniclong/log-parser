<?php

namespace App\Service;

interface RenderInterface
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function view(array $data);
}
