<?php

namespace App\Services;

use App\Core\Exceptions\SdkDefaultException;
use App\Core\Models\CommonInternalResponse;
use App\Core\Services\BaseService;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\View;

class MkcService extends BaseService
{

    public function __construct()
    {
        parent::__construct();
    }

    public function responsePing()
    {
        $response = ['ping' => 'ok'];

        return CommonInternalResponse::successResponse("Ok.")
            ->setData($response)
            ->setStatus(200);
    }

}
