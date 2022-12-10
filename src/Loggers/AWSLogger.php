<?php

namespace FelipeMenezesDM\LaravelLoggerAdapter\Loggers;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Maxbanton\Cwh\Handler\CloudWatch;
use Monolog\Logger;

class AWSLogger
{
    /**
     * Construct AWS Logger
     *
     * @return Logger
     * @throws Exception
     */
    public function __invoke() : Logger
    {
        $logName = getenv('APP_SERVICE_ID');
        $environment = strtolower(getenv('APP_ENV'));
        $logGroupName = '/aws/' . $environment . '/application/' . $logName;
        $handler = new CloudWatch($this->getClient(), $logGroupName, md5($logName), 14, 10000, [], Logger::DEBUG, true, false);

        return new Logger($logName, [$handler]);
    }

    /**
     * Get AWS client object
     *
     * @return CloudWatchLogsClient
     */
    private function getClient() : CloudWatchLogsClient
    {
        return new CloudWatchLogsClient([
            'credentials'   => false,
            'version'       => 'latest',
            'region'        => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'endpoint'      => env('AWS_ENDPOINT'),
            'account'       => env('AWS_ACCOUNT_ID'),
        ]);
    }
}