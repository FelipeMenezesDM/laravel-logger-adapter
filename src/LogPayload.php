<?php

namespace FelipeMenezesDM\LaravelLoggerAdapter;

use Carbon\Carbon;
use FelipeMenezesDM\LaravelCommons\Enums\HttpStatusCode;
use Illuminate\Support\Facades\Date;

class LogPayload
{
    private string|null $loggerId = null;

    private string|null $serviceId = null;

    private string|null $severity = null;

    private string|null $endPoint = '';

    private string|null $correlationId = null;

    private string|null $httpStatus = null;

    private int|null $httpStatusCode = null;

    private int|null $duration = 0;

    private string|null $logCode = '';

    private string|null $message = '';

    private string|null $codeLine = '';

    private array|null $artifact = [];

    private int|null $timestamp;

    private string|null $dateTime;

    private array|null $details = [];

    private const DATE_FORMAT = 'Y-m-d H:i:s.v';

    public static function build() : LogPayload
    {
        $logPayload = new self;
        $date = Date::now();
        $logPayload->setTimestamp($date->format('U.v'));
        $logPayload->setDateTime($date->format(self::DATE_FORMAT));

        return $logPayload;
    }

    public function setLoggerId(string $loggerId) : LogPayload
    {
        $this->loggerId = $loggerId;
        return $this;
    }

    public function setServiceId(string $serviceId) : LogPayload
    {
        $this->serviceId = $serviceId;
        return $this;
    }

    public function setServerity(string $severity) : LogPayload
    {
        $this->severity = $severity;
        return $this;
    }

    public function setEndPoint(string|null $endPoint) : LogPayload
    {
        $this->endPoint = $endPoint;
        return $this;
    }

    public function setCorrelationId(string $correlationId) : LogPayload
    {
        $this->correlationId = $correlationId;
        return $this;
    }

    public function setHttpStatus(int|HttpStatusCode|null $httpStatus) : LogPayload
    {
        if(!is_int($httpStatus) && !is_null($httpStatus)) {
            $httpStatus = $httpStatus->value;
        }

        $this->httpStatus = !is_null($this->getHttpStatus()) ? HttpStatusCode::from($this->getHttpStatus())->name : null;
        $this->httpStatusCode = $httpStatus;
        return $this;
    }

    public function setDuration(Carbon $start, Carbon $end) : LogPayload
    {
        if(!is_int($start)) {
            $start = $start->diff($end)->format('U.v');
        }

        $this->duration = $start;
        return $this;
    }

    public function setLogCode(string|null $logCode) : LogPayload
    {
        $this->logCode = $logCode;
        return $this;
    }

    public function setMessage(string|null $message) : LogPayload
    {
        $this->message = $message;
        return $this;
    }

    public function setCodeLine(string|null $codeLine) : LogPayload
    {
        $this->codeLine = $codeLine;
        return $this;
    }

    public function setArtifact(array|null $artifact) : LogPayload
    {
        $this->artifact = $artifact;
        return $this;
    }

    public function setTimestamp(int|null $timestamp) : LogPayload
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function setDateTime(string|null $dateTime) : LogPayload
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    public function setDetails(array|null $details) : LogPayload
    {
        $this->details = $details;
        return $this;
    }

    public function getLoggerId() : string|null
    {
        return $this->loggerId;
    }

    public function getServiceId() : string|null
    {
        return $this->serviceId;
    }

    public function getSeverity() : string|null
    {
        return $this->severity;
    }

    public function getCorrelationId() : string|null
    {
        return $this->correlationId;
    }

    public function getEndPoint() : string|null
    {
        return $this->endPoint;
    }

    public function getHttpStatus() : string|null
    {
        return $this->httpStatus;
    }

    public function getHttpStatusCode() : int|null
    {
        return $this->httpStatusCode;
    }

    public function getDuration() : int|null
    {
        return $this->duration;
    }

    public function getLogCode() : string|null
    {
        return $this->logCode;
    }

    public function getMessage() : string|null
    {
        return $this->message;
    }

    public function getCodeLine() : string|null
    {
        return $this->codeLine;
    }

    public function getArtifact() : array|null
    {
        return $this->artifact;
    }

    public function getTimestamp() : int|null
    {
        return $this->timestamp;
    }

    public function getDateTime() : string|null
    {
        return $this->dateTime;
    }

    public function getDetails() : array|null
    {
        return $this->details;
    }

    public function toArray() : array
    {
        return [
            'ServiceId'         => $this->getServiceId(),
            'Severity'          => $this->getSeverity(),
            'EndPoint'          => $this->getEndPoint(),
            'CorrelationId'     => $this->getCorrelationId(),
            'HttpStatus'        => $this->getHttpStatus(),
            'HttpStatusCode'    => $this->getHttpStatusCode(),
            'Duration'          => $this->getDuration(),
            'LogCode'           => $this->getLogCode(),
            'Message'           => $this->getMessage(),
            'CodeLine'          => $this->getCodeLine(),
            'Artifact'          => $this->getArtifact(),
            'Timestamp'         => $this->getTimestamp(),
            'DateTime'          => $this->getDateTime(),
            'Details'           => $this->getDetails(),
        ];
    }
}
