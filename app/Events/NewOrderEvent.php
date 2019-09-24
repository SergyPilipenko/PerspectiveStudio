<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewOrderEvent
{
    use Dispatchable, SerializesModels;

    public $order;

    public function __construct($order, $orderItems)
    {
//        echo json_encode($orderItems);
//        die;
        $this->order = $order;
        $this->order->orderItems = $orderItems;
    }
}
