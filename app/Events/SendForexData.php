<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendForexData implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var
     */
    public $arrows;

    /**
     * Create a new event instance.
     *
     * @param $arrows
     */
    public function __construct($arrows)
    {
        $this->arrows = $arrows;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('forextable');
    }
}
