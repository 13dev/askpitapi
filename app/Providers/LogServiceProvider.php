<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;

class LogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app('Psr\Log\LoggerInterface')->setHandlers([$this->getRotatingLogHandler()]);
    }

    public function getRotatingLogHandler($maxFiles = 7)
    {
        return (new RotatingFileHandler(storage_path('logs/lumen.log'), $maxFiles))
            ->setFormatter(new LineFormatter(null, null, true, true));
    }

    public function register()
    {

    }
}
