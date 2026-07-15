<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Mail\InvoiceMail;
use App\Models\EmailHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendInvoiceEmail
{
    /**
     * Handle the event - sends invoice email synchronously (no queue)
     *
     * @param OrderPlaced $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        try {
            $order = $event->order;

            Log::info('SendInvoiceEmail listener triggered', [
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);

            // Load relationships needed for invoice
            $order->load([
                'customer',
                'items.variant.quantity',
                'items.product'
            ]);

            // Determine recipient email
            $recipientEmail = $this->getRecipientEmail($order);
            $recipientName = $this->getRecipientName($order);

            if (!$recipientEmail || !filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                Log::warning('Invoice email not sent - invalid email', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_type' => $order->customer_type,
                    'email_provided' => $recipientEmail ?? 'null'
                ]);
                return;
            }

            Log::info('Attempting to send invoice email', [
                'order_id' => $order->id,
                'recipient' => $recipientEmail,
                'recipient_name' => $recipientName
            ]);

            $emailSubject = 'Order Successfully Placed - Invoice #' . $order->order_number;

            // Send invoice email synchronously (not queued) for immediate delivery
            Mail::to($recipientEmail, $recipientName)
                ->send(new InvoiceMail($order));

            // Send explicitly to care@chennaiangadi.com as the 3rd email
            Mail::to('care@chennaiangadi.com', 'Care Chennai Angadi')
                ->send(new InvoiceMail($order));

            // Log to EmailHistory table
            EmailHistory::create([
                'order_id' => $order->id,
                'email_type' => 'order_confirmation',
                'recipient_email' => $recipientEmail,
                'recipient_name' => $recipientName,
                'subject' => $emailSubject,
                'order_number' => $order->order_number,
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            Log::info('Invoice email sent successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'recipient' => $recipientEmail
            ]);

        } catch (\Exception $e) {
            // Log failed email to history
            if (isset($order) && isset($recipientEmail)) {
                EmailHistory::create([
                    'order_id' => $order->id,
                    'email_type' => 'order_confirmation',
                    'recipient_email' => $recipientEmail,
                    'recipient_name' => $recipientName ?? null,
                    'subject' => $emailSubject ?? 'Order Confirmation',
                    'order_number' => $order->order_number,
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'sent_at' => now(),
                ]);
            }

            Log::error('Failed to send invoice email', [
                'order_id' => $event->order->id ?? 'unknown',
                'order_number' => $event->order->order_number ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Get recipient email based on customer type
     */
    private function getRecipientEmail($order)
    {
        if ($order->customer_type === 'registered' && $order->customer) {
            return $order->customer->email;
        }

        if ($order->customer_type === 'guest' && isset($order->guest_details['email'])) {
            return $order->guest_details['email'];
        }

        return null;
    }

    /**
     * Get recipient name based on customer type
     */
    private function getRecipientName($order)
    {
        if ($order->customer_type === 'registered' && $order->customer) {
            return $order->customer->username;
        }

        if ($order->customer_type === 'guest') {
            return $order->guest_details['first_name']
                ?? $order->guest_details['name']
                ?? 'Guest';
        }

        return 'Customer';
    }
}
