<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnnouncementCreate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $announcement;
    /**
     * Create a new event instance.
     */
    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }


    public function broadcastOn()
    {
        return new Channel('announcements');
    }

    public function broadcastAs()
    {
        return "create";
    }

    public function broadcastWith()
    {
        return [
            'title' => $this->announcement->title,
            'body' => $this->announcement->body,
            'created_at' => $this->announcement->created_at->format('Y-m-d H:i:s'), // Format the created_at timestamp
        ];
    }

}
