<?php

namespace App\Services;

use App\Core\Exceptions\SdkDefaultException;
use App\Core\Models\CommonInternalResponse;
use App\Core\Services\BaseService;
use App\Traits\TokenMkcTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Exception;


class CallbackService extends BaseService
{
    use TokenMkcTrait;
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $data
     * @return CommonInternalResponse
     * @throws GuzzleException
     */
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

            $url = 'https://'. config('constants.mkc.et_subdomain') . '.rest.marketingcloudapis.com/platform/v1/ens-callbacks';

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

            return CommonInternalResponse::successResponse("Se registro el callback.")
                ->setData($response)
                ->setStatus(200);

        } catch (Exception $e) {
            $e = SdkDefaultException::newInstance($e);
            return CommonInternalResponse::errorResponse("No se pudo registrar el callback. {$e->getDefaultMessage()}")
                ->showInternalMessage(true)
                ->setStatus(400);
        }
    }
    public function  verify(array $data): CommonInternalResponse
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

            $url = 'https://'. config('constants.mkc.et_subdomain') . '.rest.marketingcloudapis.com/platform/v1/ens-verify';

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

            if ($request->getStatusCode() != '200') {
                throw new Exception(($response['error_code'] ?? 'Code') . ' - ' . ($response['message'] ?? 'Error no registrado.'));
            }

            return CommonInternalResponse::successResponse("Se verificó el callback.")
                ->setData($response)
                ->setStatus(200);

        } catch (Exception $e) {
            $e = SdkDefaultException::newInstance($e);
            return CommonInternalResponse::errorResponse("No se pudo verificar el callback. {$e->getDefaultMessage()}")
                ->showInternalMessage(true)
                ->setStatus(400);
        }
    }
    public function  get($callbackId): CommonInternalResponse
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

            $url = 'https://'. config('constants.mkc.et_subdomain') . '.rest.marketingcloudapis.com/platform/v1/ens-callbacks/'.$callbackId;

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

            return CommonInternalResponse::successResponse("Se obtuvo el callback.")
                ->setData($response)
                ->setStatus(200);

        } catch (Exception $e) {
            $e = SdkDefaultException::newInstance($e);
            return CommonInternalResponse::errorResponse("No se pudo obtener el callback. {$e->getDefaultMessage()}")
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

            $url = 'https://'. config('constants.mkc.et_subdomain') . '.rest.marketingcloudapis.com/platform/v1/ens-callbacks';

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

            return CommonInternalResponse::successResponse("Se actualizó el callback.")
                ->setData($response)
                ->setStatus(200);

        } catch (Exception $e) {
            $e = SdkDefaultException::newInstance($e);
            return CommonInternalResponse::errorResponse("No se pudo actualizar el callback. {$e->getDefaultMessage()}")
                ->showInternalMessage(true)
                ->setStatus(400);
        }
    }
    public function  getAll(): CommonInternalResponse
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

            $url = 'https://'. config('constants.mkc.et_subdomain') . '.rest.marketingcloudapis.com/platform/v1/ens-callbacks/';

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

            return CommonInternalResponse::successResponse("Se obtuvieron los callbacks.")
                ->setData($response)
                ->setStatus(200);

        } catch (Exception $e) {
            $e = SdkDefaultException::newInstance($e);
            return CommonInternalResponse::errorResponse("No se pudieron obtener los callbacks. {$e->getDefaultMessage()}")
                ->showInternalMessage(true)
                ->setStatus(400);
        }
    }
    public function  delete($callbackId): CommonInternalResponse
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

            $url = 'https://'. config('constants.mkc.et_subdomain') . '.rest.marketingcloudapis.com/platform/v1/ens-callbacks/'.$callbackId;

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

            return CommonInternalResponse::successResponse("Se elimino el callback.")
                ->setData($response)
                ->setStatus(200);

        } catch (Exception $e) {
            $e = SdkDefaultException::newInstance($e);
            return CommonInternalResponse::errorResponse("No se pudo eliminar el callback. {$e->getDefaultMessage()}")
                ->showInternalMessage(true)
                ->setStatus(400);
        }
    }
}
