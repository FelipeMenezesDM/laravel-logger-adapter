<?php

use Google\Cloud\Logging\LoggingClient;
use Monolog\Handler\PsrHandler;
use Monolog\Logger;

class GCPLogger
{
    public function __invoke() : Logger
    {
        $projectId = getenv('GCP_PROJECT_ID');
        $logName = getenv('APP_NAME');
        $logging = new LoggingClient(['projectId' => $projectId]);
        $handler = new PsrHandler($logging->psrLogger($projectId));

        return new Logger($logName, [$handler]);
    }
}