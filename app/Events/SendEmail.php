<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendEmail
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $support;
    /**
     * Create a new event instance.
     */
    public function __construct($support)
    {
        $this->support = $support;
    }
}
