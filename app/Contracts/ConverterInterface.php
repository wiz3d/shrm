<?php

namespace App\Contracts;

interface ConverterInterface
{
    public function convertToArray(string $content, string $delimiter = ','): array;
}
