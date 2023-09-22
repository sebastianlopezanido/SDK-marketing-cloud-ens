<?php

namespace App\Services;
use App\Core\Models\CommonInternalResponse;
use App\Core\Services\BaseService;
use App\Repositories\EventRepository;

class WebhookService extends BaseService
{
    /**
     * @var EventRepository
     */
    private $eventRepository;
    public function __construct(EventRepository $eventRepository)
    {
        parent::__construct();
        $this->eventRepository = $eventRepository;
    }

    public function handle(array $data, $callback): CommonInternalResponse
    {
        $event= [];
        $event['callback'] = $callback;
        $event['payload'] = $data;
        $this->eventRepository->createEvent($event);
        return CommonInternalResponse::successResponse("Received event.")
            ->setStatus(200);
    }

}
