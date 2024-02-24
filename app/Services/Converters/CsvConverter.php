<?php

namespace App\Services\Converters;

use App\Contracts\ConverterInterface;
use Illuminate\Support\Facades\Log;

class CsvConverter implements ConverterInterface
{
    public function convertToArray(string $content, string $delimiter = ','): array
    {
        $lines = explode("\n", $content); // Разбиваем контент на строки
        $data = [];
        foreach ($lines as $index => $line) {
            if (empty(trim($line))) {
                continue;
            }
            $row = str_getcsv($line, $delimiter);
            if ($index === 0) {
                $headers = $row;
                $data[] = $row;
                continue;
            }
            $data[] = $row;
        }
        return $data;
    }
}
