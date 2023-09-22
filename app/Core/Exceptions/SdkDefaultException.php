<?php

namespace App\Core\Exceptions;

use Throwable;

class SdkDefaultException extends \Exception
{
    protected $debug_message;
    protected $default_message;

    public static function newInstance(\Exception $exception): SdkDefaultException
    {
        $e = new SdkDefaultException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        return $e;
    }

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->parseDebugMessage();
    }

    protected function parseDebugMessage()
    {
        $message = "";
        $debug_message = "";

        if (str_contains($this->getMessage(), 'ORA')) {
            $debug_message = $this->getMessage();
        } else {
            $message = $this->getMessage();
        }

        $this->default_message = $message;
        $this->debug_message = $debug_message;
    }

    public function getDebugMessage()
    {
        return $this->debug_message;
    }

    public function getDefaultMessage()
    {
        return $this->default_message;
    }


}
