<?php

namespace FelipeMenezesDM\LaravelLoggerAdapter\Drivers;

use Google\Cloud\Logging\LoggingClient;
use Monolog\Handler\PsrHandler;
use Monolog\Logger;

class GCPLogger
{
    /**
     * Invoke Google Cloud Platform Log Driver
     *
     * @param array $config
     * @return Logger
     */
    public function __invoke(array $config) : Logger
    {
        $logName = getenv('APP_NAME');
        $logging = new LoggingClient(['projectId' => getenv('GCP_PROJECT_ID')]);
        $handler = new PsrHandler($logging->psrLogger($logName));

        return new Logger($logName, [$handler]);
    }
}