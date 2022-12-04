<?php

namespace FelipeMenezesDM\LaravelLoggerAdapter;

use FelipeMenezesDM\LaravelCommons\Enums\HttpStatusCode;

class LogPayload
{
    private string|null $endPoint = '';

    private int|null $httpStatus = null;

    private string|null $logCode = '';

    private string|null $message = '';

    private string|null $codeLine = '';

    private array|null $details = [];

    public static function build() : LogPayload
    {
        return new self;
    }

    public function setEndPoint(string|null $endPoint) : LogPayload
    {
        $this->endPoint = $endPoint;
        return $this;
    }

    public function setHttpStatus(int|HttpStatusCode|null $httpStatus) : LogPayload
    {
        if(!is_int($httpStatus) && !is_null($httpStatus)) {
            $httpStatus = $httpStatus->value;
        }

        $this->httpStatus = $httpStatus;
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

    public function setDetails(array|null $details) : LogPayload
    {
        $this->details = $details;
        return $this;
    }

    public function getEndPoint() : string|null
    {
        return $this->endPoint;
    }

    public function getHttpStatus() : string|null
    {
        return $this->httpStatus;
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

    public function getDetails() : array|null
    {
        return $this->details;
    }

    public function toArray() : array
    {
        return [
            'EndPoint'          => $this->getEndPoint(),
            'HttpStatus'        => $this->getHttpStatus() ? HttpStatusCode::from($this->getHttpStatus())->name : null,
            'HttpStatusCode'    => $this->getHttpStatus(),
            'LogCode'           => $this->getLogCode(),
            'Message'           => $this->getMessage(),
            'CodeLine'          => $this->getCodeLine(),
            'Details'           => $this->getDetails(),
        ];
    }
}
