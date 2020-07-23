<?php

namespace App\Service\Generator\Detail;

class DateGenerator implements DetailGeneratorInterface
{
    /**
     * @return string
     */
    public function handle(): string
    {
        return sprintf('%s%s%s', '[', date('d/m/Y:h:i:s O'), ']');
    }
}
