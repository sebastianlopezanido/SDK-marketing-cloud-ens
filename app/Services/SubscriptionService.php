<?php

namespace App\Services;

use App\Core\Exceptions\SdkDefaultException;
use App\Core\Models\CommonInternalResponse;
use App\Core\Services\BaseService;
use App\Traits\TokenMkcTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Exception;


class SubscriptionService extends BaseService
{
    use TokenMkcTrait;

    public function __construct()
    {
        parent::__construct();
    }

    public function create(array $data): CommonInternalResponse
    {
        try {
            $getToken = $this->getMkcToken();

            //busco el token
            if ($getToken->getStatusCode() == '200') {
                $content = json_decode($getToken->getBody()->getContents(), true);
                $token = $content['access_token'];
            } else {
                throw new Exception("Error al obtener el token.");
            }

            //llamo a la api
            $client = new Client();

            $url = 'https://'. config('constants.mkc.et_subdomain') . '.rest.marketingcloudapis.com/platform/v1/ens-subscriptions';

            $json_body = json_encode($data);

            $request = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer '. $token,
                    'content-type' => 'application/json',
                ],
                'body' => $json_body,
                'http_errors' => false
            ]);

            $response = json_decode($request->getBody()->getContents(), true);

            if ($request->getStatusCode() != '201') {
                throw new Exception(($response['error_code'] ?? 'Code') . ' - ' . ($response['message'] ?? 'Error no registrado.'));
            }

            return CommonInternalResponse::successResponse("Se registro la subscription.")
                ->setData($response)
                ->setStatus(200);

        } catch (Exception $e) {
            $e = SdkDefaultException::newInstance($e);
            return CommonInternalResponse::errorResponse("No se pudo registrar la subscription. {$e->getDefaultMessage()}")
                ->showInternalMessage(true)
                ->setStatus(400);
        }
    }
    public function delete($subscriptionId): CommonInternalResponse
    {
        try {
            $getToken = $this->getMkcToken();

            //busco el token
            if ($getToken->getStatusCode() == '200') {
                $content = json_decode($getToken->getBody()->getContents(), true);
                $token = $content['access_token'];
            } else {
                throw new Exception("Error al obtener el token.");
            }

            //llamo a la api
            $client = new Client();

            $url = 'https://'. config('constants.mkc.et_subdomain') . '.rest.marketingcloudapis.com/platform/v1/ens-subscriptions/'.$subscriptionId;


            $request = $client->delete($url, [
                'headers' => [
                    'Authorization' => 'Bearer '. $token,
                    'content-type' => 'application/json',
                ],
                'http_errors' => false
            ]);

            $response = json_decode($request->getBody()->getContents(), true);

            if ($request->getStatusCode() != '200') {
                throw new Exception(($response['error_code'] ?? 'Code') . ' - ' . ($response['message'] ?? 'Error no registrado.'));
            }

            return CommonInternalResponse::successResponse("Se elimino la subscription.")
                ->setData($response)
                ->setStatus(200);

        } catch (Exception $e) {
            $e = SdkDefaultException::newInstance($e);
            return CommonInternalResponse::errorResponse("No se pudo eliminar la subscription. {$e->getDefaultMessage()}")
                ->showInternalMessage(true)
                ->setStatus(400);
        }
    }
    public function get($subscriptionId): CommonInternalResponse
    {
        try {
            $getToken = $this->getMkcToken();

            //busco el token
            if ($getToken->getStatusCode() == '200') {
                $content = json_decode($getToken->getBody()->getContents(), true);
                $token = $content['access_token'];
            } else {
                throw new Exception("Error al obtener el token.");
            }

            //llamo a la api
            $client = new Client();

            $url = 'https://'. config('constants.mkc.et_subdomain') . '.rest.marketingcloudapis.com/platform/v1/ens-subscriptions/'.$subscriptionId;


            $request = $client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer '. $token,
                    'content-type' => 'application/json',
                ],
                'http_errors' => false
            ]);

            $response = json_decode($request->getBody()->getContents(), true);

            if ($request->getStatusCode() != '200') {
                throw new Exception(($response['error_code'] ?? 'Code') . ' - ' . ($response['message'] ?? 'Error no registrado.'));
            }

            return CommonInternalResponse::successResponse("Se obtuvo la subscription.")
                ->setData($response)
                ->setStatus(200);

        } catch (Exception $e) {
            $e = SdkDefaultException::newInstance($e);
            return CommonInternalResponse::errorResponse("No se pudo obtener la subscription. {$e->getDefaultMessage()}")
                ->showInternalMessage(true)
                ->setStatus(400);
        }
    }
    public function getByCallbackId($callbackId): CommonInternalResponse
    {
        try {
            $getToken = $this->getMkcToken();

            //busco el token
            if ($getToken->getStatusCode() == '200') {
                $content = json_decode($getToken->getBody()->getContents(), true);
                $token = $content['access_token'];
            } else {
                throw new Exception("Error al obtener el token.");
            }

            //llamo a la api
            $client = new Client();

            $url = 'https://'. config('constants.mkc.et_subdomain') . '.rest.marketingcloudapis.com/platform/v1/ens-subscriptions-by-cb/'.$callbackId;


            $request = $client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer '. $token,
                    'content-type' => 'application/json',
                ],
                'http_errors' => false
            ]);

            $response = json_decode($request->getBody()->getContents(), true);

            if ($request->getStatusCode() != '200') {
                throw new Exception(($response['error_code'] ?? 'Code') . ' - ' . ($response['message'] ?? 'Error no registrado.'));
            }

            return CommonInternalResponse::successResponse("Se obtuvieron las subscription by callbackId.")
                ->setData($response)
                ->setStatus(200);

        } catch (Exception $e) {
            $e = SdkDefaultException::newInstance($e);
            return CommonInternalResponse::errorResponse("No se pudieron obtener la subscription by callbackId. {$e->getDefaultMessage()}")
                ->showInternalMessage(true)
                ->setStatus(400);
        }
    }
    public function update(array $data): CommonInternalResponse
    {
        try {
            $getToken = $this->getMkcToken();

            //busco el token
            if ($getToken->getStatusCode() == '200') {
                $content = json_decode($getToken->getBody()->getContents(), true);
                $token = $content['access_token'];
            } else {
                throw new Exception("Error al obtener el token.");
            }

            //llamo a la api
            $client = new Client();

            $url = 'https://'. config('constants.mkc.et_subdomain') . '.rest.marketingcloudapis.com/platform/v1/ens-subscriptions';

            $json_body = json_encode($data);

            $request = $client->put($url, [
                'headers' => [
                    'Authorization' => 'Bearer '. $token,
                    'content-type' => 'application/json',
                ],
                'body' => $json_body,
                'http_errors' => false
            ]);

            $response = json_decode($request->getBody()->getContents(), true);

            if ($request->getStatusCode() != '200') {
                throw new Exception(($response['error_code'] ?? 'Code') . ' - ' . ($response['message'] ?? 'Error no registrado.'));
            }

            return CommonInternalResponse::successResponse("Se actualizó la subscription.")
                ->setData($response)
                ->setStatus(200);

        } catch (Exception $e) {
            $e = SdkDefaultException::newInstance($e);
            return CommonInternalResponse::errorResponse("No se pudo actualizar la subscription. {$e->getDefaultMessage()}")
                ->showInternalMessage(true)
                ->setStatus(400);
        }
    }
}
