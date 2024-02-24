<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\ConverterInterface;
use App\Services\Converters\CsvConverter;

class ConverterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ConverterInterface::class, function ($app, $parameters) {
            $type = $parameters['type'] ?? 'default';
            switch ($type) {
                case 'csv':
                    return new CsvConverter();
                default:
                    throw new \InvalidArgumentException("Unsupported file type: $type");
            }
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
