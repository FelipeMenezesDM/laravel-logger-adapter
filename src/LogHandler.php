<?php

namespace FelipeMenezesDM\LaravelLoggerAdapter;

use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Date;

class LogHandler extends Log
{
    /**
     * Request global ID.
     *
     * @var string
     */
    protected static string $correlationId;

    /**
     * Log error occurrences.
     *
     * @param string|null $message
     * @param LogPayload|null $context
     * @return void
     */
    public static function error(string|null $message, LogPayload $context = null) : void
    {
        self::handlePayload($message, $context, 'ERROR');
    }

    /**
     * Log warning occurrences.
     *
     * @param string|null $message
     * @param LogPayload|null $context
     * @return void
     */
    public static function warning(string|null $message, LogPayload $context = null) : void
    {
        self::handlePayload($message, $context, 'WARNING');
    }

    /**
     * Log info occurrences.
     *
     * @param string|null $message
     * @param LogPayload|null $context
     * @return void
     */
    public static function info(string|null $message, LogPayload $context = null) : void
    {
        self::handlePayload($message, $context, 'INFO');
    }

    /**
     * Handle log payload.
     *
     * @param string|null $message
     * @param LogPayload|null $context
     * @param string $severity
     * @return void
     */
    private static function handlePayload(string|null $message, LogPayload|null $context, string $severity) : void
    {
        if(empty(self::$correlationId)) {
            self::$correlationId = Uuid::uuid4()->toString();

            if(function_exists('request') && request()->hasHeader('CorrelationId')) {
                self::$correlationId = request()->header('CorrelationId');
            }
        }

        $date = Date::now();
        $defaultPayload = [
            'Channel'       => env('APP_LOG_CHANNEL', 'stack'),
            'Domain'        => env('APP_NAME'),
            'CorrelationId' => self::$correlationId,
            'ServiceId'     => env('APP_SERVICE_ID'),
            'Timestamp'     => $date->getTimestamp() . $date->format('v'),
            'DateTime'      => $date->format('Y-m-d H:i:s.v'),
            'Severity'      => $severity,
        ];

        if(!empty($context)) {
            $defaultPayload = [...$defaultPayload, ...$context->toArray()];
        }

        switch($severity) {
            case 'ERROR' :
                parent::error($message ?? '', $defaultPayload);
                break;
            case 'WARNING' :
                parent::warning($message ?? '', $defaultPayload);
                break;
            default :
                parent::info($message ?? '', $defaultPayload);
                break;
        }
    }
}
