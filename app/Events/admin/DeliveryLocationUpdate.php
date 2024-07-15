<?php

namespace App\Events\admin;

use App\Models\Deliveryman;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryLocationUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $name;
    public $lat;
    public $lng;

    /**
     * Create a new event instance.
     */
    public function __construct($latitude,$longitude,$name)
    {
        $this->lat = $latitude;
        $this->lng = $longitude;
        $this->name = $name;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel("deliveries");
    }

    public function broadcastAs()
    {
        return 'updated-location';
    }
    public function broadcastWith()
    {
        return [
            'lat'=>$this->lat,
            'lng'=>$this->lng,
            'name'=>$this->name
        ];
    }
}
