<?php

namespace App\Http\Controllers\Api;

use App\Core\Controller\BaseController;
use App\Http\Controllers\Controller;
use App\Services\WebhookService;
use Illuminate\Http\Request;

/**
 * @property WebhookService webhookService
 */
class WebhookController extends BaseController
{
    /**
     * MkcController constructor.
     * @param WebhookService $webhookService
     */
    public function __construct(WebhookService $webhookService)
    {
        parent::__construct();
        $this->webhookService = $webhookService;
    }

    public function handle(Request $request, $callback)
    {
        return $this->respondWithCommonResponse($this->webhookService->handle($request->all(), $callback));
    }

}
