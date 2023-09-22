<?php

namespace App\Http\Controllers\Api;

use App\Core\Controller\BaseController;
use App\Http\Requests\Api\Subscription\CreateSubscriptionRequest;
use App\Http\Requests\Api\Subscription\UpdateSubscriptionRequest;
use App\Services\SubscriptionService;

/**
 * @property SubscriptionService subscriptionService
 */
class SubscriptionController extends BaseController
{
    /**
     * MkcController constructor.
     * @param SubscriptionService $subscriptionService
     */
    public function __construct(SubscriptionService $subscriptionService)
    {
        parent::__construct();
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Create a new subscription.
     *
     * @param CreateSubscriptionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateSubscriptionRequest $request)
    {
        return $this->respondWithCommonResponse($this->subscriptionService->create($request->validated()));
    }

    /**
     * Update an existing subscription.
     *
     * @param UpdateSubscriptionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSubscriptionRequest $request)
    {
        return $this->respondWithCommonResponse($this->subscriptionService->update($request->validated()));
    }

    /**
     * Retrieve a subscription by its ID.
     *
     * @param $subscriptionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($subscriptionId)
    {
        return $this->respondWithCommonResponse($this->subscriptionService->get($subscriptionId));
    }

    /**
     * Retrieve subscriptions by callback ID.
     *
     * @param $callbackId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByCallbackId($callbackId)
    {
        return $this->respondWithCommonResponse($this->subscriptionService->getByCallbackId($callbackId));
    }

    /**
     * Delete a subscription by its ID.
     *
     * @param $subscriptionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($subscriptionId)
    {
        return $this->respondWithCommonResponse($this->subscriptionService->delete($subscriptionId));
    }

}
