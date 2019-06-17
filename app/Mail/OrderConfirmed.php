<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Orders;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;



    protected $order;
    protected $orderlist;
    protected $id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $orderlist)
    {
        $this->order = $order;
        $this->orderlist = $orderlist;
        $this->id = $order->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.order-confirmed')->subject("Order ID: $this->id [Order Confirmed]")->with(['order' => $this->order, 'orderlist' => $this->orderlist]) ;
    }
}
