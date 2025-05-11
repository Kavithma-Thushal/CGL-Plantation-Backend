<?php

namespace App\Mail;

use App\Models\Customer;
use App\Models\UserPackage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userPackage;
    public $customer;
    /**
     * Create a new message instance.
     */
    public function __construct(UserPackage $userPackage, Customer $customer)
    {
        //
        $this->userPackage = $userPackage;
        $this->customer = $customer;
    }

      /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Payment Receipt'
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payment-receipt',
            with: [
                'package' => $this->userPackage,
                'customer' => $this->customer,
                'due_amount' => round($this->userPackage->total_amount - $this->userPackage->receipts()->sum('amount'), 2),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
