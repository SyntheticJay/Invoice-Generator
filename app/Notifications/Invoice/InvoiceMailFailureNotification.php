<?php

namespace App\Notifications\Invoice;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\Invoice\Invoice;

class InvoiceMailFailureNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private readonly Invoice $invoice, private ?string $why = null) {}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type'        => 'error',
            'message'     => 'Failed to send email for invoice with reference: ' . $this->invoice->reference . '. ' . $this->why ?? '',
            'time'        => now()->toDateTimeString()
        ];
    }
}
