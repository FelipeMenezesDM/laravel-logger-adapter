<?php

namespace FelipeMenezesDM\LaravelLoggerAdapter\Loggers;

use Google\Cloud\Logging\LoggingClient;
use Monolog\Handler\NullHandler;
use Monolog\Handler\PsrHandler;
use Monolog\Logger;

class GCPLogger
{
    /**
     * Construct GCP Logger
     *
     * @return Logger
     */
    public function __invoke() : Logger
    {
        $projectId = getenv('GCP_PROJECT_ID');
        $logName = getenv('APP_SERVICE_ID');

        if(env('ON_GITHUB_ACTIONS', false)) {
            return new Logger($logName, [new NullHandler()]);
        }

        $logging = new LoggingClient(['projectId' => $projectId]);
        $handler = new PsrHandler($logging->psrLogger($projectId));

        return new Logger($logName, [$handler]);
    }
}