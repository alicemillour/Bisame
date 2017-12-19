<?php

namespace App\Events;

use App\Events\Event;
use App\Message;
use App\Discussion;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessagePosted extends Event
{
    use SerializesModels;

    public $message;
    public $discussion;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(\App\Message $message, \App\Discussion $discussion)
    {
        $this->message = $message;
        $this->discussion = $discussion;
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
