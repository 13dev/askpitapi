<?php

namespace App;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Laravel\Lumen\Application as LumenApplication;

class Application extends LumenApplication
{
    /**
     * {@inheritdoc}
     */
    protected function getMonologHandler()
    {
        $maxRotatedFiles = 3;

        return (new RotatingFileHandler(storage_path('logs/lumen.log'), $maxRotatedFiles))
            ->setFormatter(new LineFormatter(null, null, true, true));
    }
}
