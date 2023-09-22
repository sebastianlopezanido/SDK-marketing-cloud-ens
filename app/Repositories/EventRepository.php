<?php

namespace App\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Models\Event;

class EventRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     *
     * @param Event $event
     * @return void
     */
    public function __construct(Event $event)
    {
        parent::__construct($event);
    }

    public function createEvent(array $data)
    {
        return Event::create([
            'callback' => $data['callback'],
            'payload' => json_encode($data['payload']) // Encode the payload as JSON
        ]);
    }

}
