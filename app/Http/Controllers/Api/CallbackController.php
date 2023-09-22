<?php

namespace App\Http\Controllers\Api;

use App\Core\Controller\BaseController;
use App\Http\Requests\Api\Callback\CreateCallbackRequest;
use App\Http\Requests\Api\Callback\UpdateCallbackRequest;
use App\Http\Requests\Api\Callback\verifyCallbackRequest;
use App\Services\CallbackService;
use Illuminate\Http\Request;

/**
 * @property CallbackService callbackService
 */
class CallbackController extends BaseController
{
    /**
     * MkcController constructor.
     * @param CallbackService $callbackService
     */
    public function __construct(CallbackService $callbackService)
    {
        parent::__construct();
        $this->callbackService = $callbackService;
    }
    /**
     * Create a new callback resource.
     *
     * @param CreateCallbackRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateCallbackRequest $request)
    {
        return $this->respondWithCommonResponse($this->callbackService->create($request->validated()));
    }

    /**
     * Update an existing callback resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCallbackRequest $request)
    {
        return $this->respondWithCommonResponse($this->callbackService->update($request->validated()));
    }

    /**
     * Retrieve a list of all callback resources.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        return $this->respondWithCommonResponse($this->callbackService->getAll());
    }

    /**
     * Verify a callback resource.
     *
     * @param verifyCallbackRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(verifyCallbackRequest $request)
    {
        return $this->respondWithCommonResponse($this->callbackService->verify($request->validated()));
    }

    /**
     * Retrieve details of a specific callback resource.
     *
     * @param $callbackId
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($callbackId)
    {
        return $this->respondWithCommonResponse($this->callbackService->get($callbackId));
    }

    /**
     * Delete a specific callback resource.
     *
     * @param $callbackId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($callbackId)
    {
        return $this->respondWithCommonResponse($this->callbackService->delete($callbackId));
    }
}
