<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait TokenMkcTrait
{
    protected function getMkcToken(): \Psr\Http\Message\ResponseInterface
    {
        $client = new Client();

        $et_subdomain = config('constants.mkc.et_subdomain');

        $url = 'https://' . $et_subdomain . '.auth.marketingcloudapis.com/v2/token';

        $keys = new \stdClass();

        $keys->grant_type = "client_credentials";
        $keys->client_id = config('constants.mkc.et_clientid');
        $keys->client_secret = config('constants.mkc.et_secret');
        $keys->account_id = config('constants.mkc.et_mid');

        $json_body = json_encode($keys);

        return $client->post($url, [
            'headers' => [
                'content-type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'body' => $json_body
        ]);
    }

}
