<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $status;
    public $notes;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param string $status
     * @param string|null $notes
     */
    public function __construct(Order $order, string $status, ?string $notes = null)
    {
        $this->order = $order;
        $this->status = $status;
        $this->notes = $notes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromAddress = config('mail.from.address', 'care@chennaiangadi.com');
        $fromName = config('mail.from.name', 'Chennai Angadi');

        return $this->from($fromAddress, $fromName)
            ->replyTo($fromAddress, $fromName)
            ->subject('Order Status Update - ' . $this->order->order_number)
            ->view('emails.order-status-update')
            ->with([
                'order' => $this->order,
                'status' => $this->status,
                'notes' => $this->notes
            ]);
    }

    /**
     * Get the customer name for the email
     */
    public function getCustomerName()
    {
        if ($this->order->customer_type === 'registered' && $this->order->customer) {
            return $this->order->customer->username ?? $this->order->customer->name ?? 'Valued Customer';
        }

        return $this->order->billing_address['name']
            ?? $this->order->guest_details['name']
            ?? 'Valued Customer';
    }
}
