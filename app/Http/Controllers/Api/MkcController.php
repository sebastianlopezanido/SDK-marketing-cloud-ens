<?php

namespace App\Http\Controllers\Api;

use App\Core\Controller\BaseController;
use App\Http\Requests\Api\CreatePushMessageRequest;
use App\Http\Requests\Api\DataExtensionAddRowRequest;
use App\Http\Requests\Api\DataExtensionCreateRequest;
use App\Http\Requests\Api\DataExtensionUpdateRequest;
use App\Http\Requests\Api\JourneyCreateRequest;
use App\Http\Requests\Api\SendMessagesRequest;
use App\Http\Requests\Api\SendPushRequest;
use App\Http\Requests\Api\SendsGenerateSentObjectRequest;
use App\Http\Requests\Api\SendSmsRequest;
use App\Services\MkcService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @property MkcService mkcService
 */
class MkcController extends BaseController
{
    /**
     * MkcController constructor.
     * @param MkcService $mkcService
     */
    public function __construct(MkcService $mkcService)
    {
        parent::__construct();
        $this->mkcService = $mkcService;
    }

    public function responsePing()
    {
        return $this->respondWithCommonResponse($this->mkcService->responsePing());
    }


}
