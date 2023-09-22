<?php

namespace App\Core\Controller\Traits;

use App\Core\Models\CommonInternalResponse;

/**
 * Trait CommonResponse
 * @package App\Core\Controller\Traits
 */
trait CommonResponse
{
    /**
     * Variable to add message in debug mode
     *
     * @var string
     */
    private $debug_message = '';

    /**
     * Set message for common response
     *
     * @var string
     */
    private $commonResponseMessage = '';

    /**
     * Set message for common response
     *
     * @var string
     */
    private $commonResponseErrorMessage = '';


    /**
     * Variable to add message in debug mode
     *
     * @param $debug_message
     * @return self
     */
    public function setDebugMessage($debug_message)
    {
        $this->debug_message = $debug_message;

        return $this;
    }

    public function getDebugMessageArray()
    {
        $o = explode(PHP_EOL, $this->debug_message);

        /** @var \Illuminate\Support\Collection $col */
        $col = collect($o);

        // creo una sub coleccion con valores que deben ser del mismo key
        $orphanValues = $col->filter(function ($value, $key) {
            return preg_match("/^\\s/", $value);
        });
        // filtro la coleccion
        $col = $col->diffKeys($orphanValues);
        // agrego los valores de la coleccion nueva a las key de la col original
        $orphanValues->each(function ($orphan_value, $k) use (&$col) {
            $i  = getClosestIndex($k, $col->keys()->all());

            if ($i > $k) {
                $keys = array_keys($col->keys()->all(), $i);
                $i = $col->keys()->get(array_pop($keys) - 1);
            }

            $col = $col->map(function ($value, $j) use ($i, $orphan_value) {
                if ($j == $i) {
                    return $value . $orphan_value;
                }
                return $value;
            });
        });

        // mapeo para armar una coleccion key value
        $col = $col->map(function ($value) {
            return [
                'key' => substr($value, 0, strpos($value, ':')),
                'value' => substr($value, strpos($value, ':'), strlen($value))
            ];
        });
        // seteo la key para cada item
        $col = $col->keyBy(function ($item) {
            return trim($item['key']);
        });
        // mapeo solo el value para cada item
        $col = $col->map(function ($item) {
            return trim(ltrim($item['value'], ':')); //
        });
        // veo si algun item tiene saltos de linea y creo un array
        $col = $col->map(function ($value) {
            if (strpos($value, "\n")) {
                return explode("\n", $value);
            }
            return $value;
        });
        // filtro si el valor es vacio
        return $col->filter(function ($value) {
            if (is_array($value)) {
                return $value;
            }
            return trim($value) != '';
        });
    }

    public function setCommonResponseMessages(string $message = '', string $errorMessage = '')
    {
        $this->commonResponseMessage = $message;
        $this->commonResponseErrorMessage = $errorMessage;

        return $this;
    }

    protected function respondWithCommonResponse(CommonInternalResponse $response)
    {
        if ($response->error) {
            $message = "{$this->commonResponseErrorMessage} ";

            if ($response->show_service_message) {
                $message .= $response->message;
            }

            if ($response->show_service_message && $response->show_internal_message) {
                $message .= " {$response->internal_message}";
            }

            return $this->setStatusCode($response->status)
                ->setDebugMessage($response->debug_message)
                ->respondWithError($message, $response->getData());
        } else {
            $message = "{$this->commonResponseMessage} ";

            if ($response->show_service_message) {
                $message .= $response->message;
            }

            return $this->setStatusCode($response->status)
                ->respondWithSuccess($message, $response->getData());
        }
    }

}
