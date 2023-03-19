<?php

namespace FelipeMenezesDM\LaravelLoggerAdapter;

use FelipeMenezesDM\LaravelLoggerAdapter\Enums\SeverityEnum;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class LogHandler extends Log
{
    /**
     * Limer list
     *
     * @var array
     */
    protected static array $timers = [];

    /**
     * Register new logger
     *
     * @param string $loggerId
     * @return void
     */
    public static function registerLogger(string $loggerId) : void
    {
        self::$timers[$loggerId] = Date::now();
    }

    /**
     * Log error occurrences.
     *
     * @param string|null $message
     * @param LogPayload|null $context
     * @return void
     */
    public static function error(string|null $message, LogPayload $context = null) : void
    {
        self::handlePayload($message, $context, SeverityEnum::ERROR);
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
        self::handlePayload($message, $context, SeverityEnum::WARNING);
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
        self::handlePayload($message, $context, SeverityEnum::INFO);
    }

    /**
     * Handle log payload.
     *
     * @param string|null $message
     * @param LogPayload|null $context
     * @param string $severity
     * @return void
     */
    private static function handlePayload(string|null $message, LogPayload|null $context, SeverityEnum $severity) : void
    {
        if(!empty($context)) {
            $now = Date::now();
            $context->setServiceId(env('APP_SERVICE_ID'));
            $context->setServerity($severity->name);
            $context->setDuration((self::$timers[$context->getLoggerId()] ?? $now), $now);
        }

        switch($severity) {
            case SeverityEnum::ERROR :
                parent::error($message ?? '', $context ?: $context->toArray());
                break;
            case SeverityEnum::WARNING :
                parent::warning($message ?? '', $context ?: $context->toArray());
                break;
            default :
                parent::info($message ?? '', $context ?: $context->toArray());
                break;
        }
    }
}
