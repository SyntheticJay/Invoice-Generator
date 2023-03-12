<?php

namespace App\Jobs\Invoice;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

use App\Models\Invoice\Invoice;

use App\Mail\Invoice\InvoiceEmail;

use App\Enums\Invoice\InvoiceAction;

use App\Notifications\Invoice\InvoiceMailFailureNotification;

class SendInvoiceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly Invoice $invoice,
        private readonly array|null $bcc = [],
        private readonly array|null $cc = []
    ) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Sending invoice: ' . $this->invoice->id);

        $directory = public_path('invoices') . '/' . $this->invoice->files->last()->file_name;
    
        if (!file_exists($directory)) {
            $this->failed(null, 'Invoice PDF could not be found.');
            return;
        }

        try {
            Mail::to($this->invoice->customer->email)
                ->send(new InvoiceEmail($this->invoice))
                ->bcc($this->bcc)
                ->cc($this->cc);
            
            $invoice->actions->create([
                'user_id'     => auth()->user()->id,
                'action'      => InvoiceAction::EMAIL_SENT,
                'description' => 'Email sent to ' . $this->invoice->customer->email . '.'
            ]);
        } catch (\Exception $e) {
            $this->failed($e, 'Caught an error while trying to send the email.');
            return;
        }
    }

    /**
     * The job failed to process.
     *
     * @return void
     */
    public function failed($exception = null, $why = null)
    {
        $this->invoice->creator->notify(
            new InvoiceMailFailureNotification($this->invoice, $why)
        );

        if ($exception) report($exception);
    }
}
