<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $taxBreakdown;
    public $storeDetails;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->calculateTaxBreakdown();
        $this->prepareStoreDetails();
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
                    ->subject('Order Successfully Placed - Invoice #' . $this->order->order_number)
                    ->view('emails.invoice-email')
                    ->with([
                        'order' => $this->order,
                        'taxBreakdown' => $this->taxBreakdown,
                        'storeDetails' => $this->storeDetails
                    ]);
    }

    /**
     * Calculate GST breakdown from order items
     * This uses ACTUAL database values, not recalculated
     */
    private function calculateTaxBreakdown()
    {
        $breakdown = [
            'cgst' => 0,
            'sgst' => 0,
            'igst' => 0,
            'total_tax' => 0,
            'items' => []
        ];

        // Get store state (should come from config/settings)
        $storeState = config('app.store_state', 'Tamil Nadu');
        
        // Get customer state
        $customerState = $this->getCustomerState();
        $isSameState = (strtolower($customerState) === strtolower($storeState));

        foreach ($this->order->items as $item) {
            $product = $item->product;
            if (!$product) continue;

            $taxableAmount = $item->total;
            $itemTaxData = [
                'product_name' => $item->product_productname,
                'variant_name' => $item->variant_name,
                'hsn' => $product->hsn ?? 'N/A',
                'qty' => $item->qty,
                'price' => $item->price,
                'taxable_amount' => $taxableAmount,
                'cgst_rate' => 0,
                'cgst_amount' => 0,
                'sgst_rate' => 0,
                'sgst_amount' => 0,
                'igst_rate' => 0,
                'igst_amount' => 0,
                'tax_type' => 'N/A'
            ];

            if ($isSameState) {
                // Intrastate: CGST + SGST
                $sgstRate = $product->sgst ?? 0;
                $cgstRate = $sgstRate; // CGST = SGST

                $sgstAmount = ($taxableAmount * $sgstRate) / 100;
                $cgstAmount = ($taxableAmount * $cgstRate) / 100;

                $itemTaxData['sgst_rate'] = $sgstRate;
                $itemTaxData['sgst_amount'] = $sgstAmount;
                $itemTaxData['cgst_rate'] = $cgstRate;
                $itemTaxData['cgst_amount'] = $cgstAmount;
                $itemTaxData['tax_type'] = 'CGST+SGST';

                $breakdown['cgst'] += $cgstAmount;
                $breakdown['sgst'] += $sgstAmount;
            } else {
                // Interstate: IGST
                $igstRate = $product->igst ?? 0;
                $igstAmount = ($taxableAmount * $igstRate) / 100;

                $itemTaxData['igst_rate'] = $igstRate;
                $itemTaxData['igst_amount'] = $igstAmount;
                $itemTaxData['tax_type'] = 'IGST';

                $breakdown['igst'] += $igstAmount;
            }

            $breakdown['items'][] = $itemTaxData;
        }

        $breakdown['total_tax'] = $breakdown['cgst'] + $breakdown['sgst'] + $breakdown['igst'];
        $this->taxBreakdown = $breakdown;
    }

    /**
     * Get customer state for tax calculation
     */
    private function getCustomerState()
    {
        if ($this->order->customer_type === 'registered' && $this->order->customer) {
            return $this->order->customer->state ?? 'Tamil Nadu';
        }

        // Guest - default to store state or from guest details
        return $this->order->guest_details['state'] ?? 'Tamil Nadu';
    }

    /**
     * Prepare store details (should come from settings/config)
     */
    private function prepareStoreDetails()
    {
        $this->storeDetails = [
            'name' => 'Chennai Angadi',
            'address' => '15/G, Muthu St, Mylapore, Chennai - 600004',
            'mobile' => '+91 59436 76695',
            'email' => 'care@chennaiangadi.com',
            'gstin' => 'GSTIN_NUMBER_HERE', // TODO: Add from settings
            'logo_url' => asset('assets/imgs/theme/ChennaiAngadiLogo.png')
        ];
    }
}
