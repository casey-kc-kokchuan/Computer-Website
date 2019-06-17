<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;
    protected $id;
    protected $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $id, $name)
    {
        $this->token = $token;
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.order-placed')->subject("Order ID: $this->id [Order Confirmation]")->with(['token' => $this->token, 'id' => $this->id, 'name' => $this->name]);
    }
}
