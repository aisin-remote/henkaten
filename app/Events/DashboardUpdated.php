<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DashboardUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $is_updated;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($is_updated)
    {
        $this->is_updated = $is_updated;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            // loading-list
            new Channel('henkaten'),
        ];
    }
}
