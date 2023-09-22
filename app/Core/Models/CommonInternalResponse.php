<?php

namespace App\Core\Models;

class CommonInternalResponse
{
    /**
     * @var boolean
     */
    public $error;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $debug_message;

    /**
     * @var string
     */
    public $internal_message;

    /**
     * @var bool
     */
    public $show_service_message;

    /**
     * @var bool
     */
    public $show_internal_message;

    /**
     * @var int
     */
    public $status;

    /**
     * @var mixed
     */
    public $data;

    public function __construct(bool $error = false, string $message = '', string $debug_message = '', int $status = 200)
    {
        $this->error = $error;
        $this->message = $message;
        $this->debug_message = $debug_message;
        $this->status = $status;
        $this->show_service_message = true;
        $this->show_internal_message = false;
    }

    public function setStatus(int $status): CommonInternalResponse
    {
        $this->status = $status;

        return $this;
    }

    public function setMessage(string $message, bool $debug = false): CommonInternalResponse
    {
        if ($debug) {
            $this->debug_message = $message;
        } else {
            $this->message = $message;
        }

        return $this;
    }

    public function setError(bool $error): CommonInternalResponse
    {
        $this->error = $error;

        return $this;
    }

    public function setException($ex, $status = 500)
    {
        //seteo mensaje y statuc si lo tiene sino seteo un 500
    }

    public function showServiceMessage(bool $show): CommonInternalResponse
    {
        $this->show_service_message = $show;

        return $this;
    }

    public function showInternalMessage(bool $show): CommonInternalResponse
    {
        $this->show_internal_message = $show;

        return $this;
    }

    public function parseInternalMessage(): CommonInternalResponse
    {
        $arr_msg = explode(PHP_EOL, $this->debug_message);

        if (trim($this->debug_message) != '' && count($arr_msg) > 3) {
            $error_message = $arr_msg[1]; // traigo la linea con el mensaje de error de oracle

            $arr_message = explode(':', $error_message);

            $message = array_key_exists(3, $arr_message) ? $arr_message[3] : last($arr_message); // solo me quedo con la respuesta, sin codigos y sin info extra

            $this->internal_message = ucfirst(trim($message));
        }

        return $this;
    }

    public static function newInstance(bool $error, string $message = '', string $error_message = '', int $status = 200, int $error_status = 500)
    {
        $response = new CommonInternalResponse($error);

        if ($error) {
            $response->message = $error_message;
            $response->status = $error_status;
        } else {
            $response->message = $message;
            $response->status = $status;
        }

        return $response;
    }

    public static function successResponse(string $message = ''): CommonInternalResponse
    {
        $response = new CommonInternalResponse(false, $message, '');

        return $response;
    }

    public static function errorResponse($message, string $debug_message = ''): CommonInternalResponse
    {
        $response = new CommonInternalResponse(true, $message, $debug_message);

        return $response->setStatus(500)->parseInternalMessage();
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
    
}
