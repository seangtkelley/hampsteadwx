<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Alert extends Event
{
    use SerializesModels;

    public $method;
    public $data;

    /**
     * Create a new event instance.
     *
     * @param string $method
     * @param array $data
     * @return mixed
     */
    public function __construct($method, $data)
    {
        $this->method = $method;
        $this->data   = $data;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

}
