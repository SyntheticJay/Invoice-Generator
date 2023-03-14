<?php

namespace App\Jobs\Invoice;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Invoice\Invoice;

use App\Notifications\Invoice\InvoiceGenerationFailureNotification;

class GenerateInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Generating invoice: ' . $this->invoice->id);

        $invoice   = $this->invoice;
        $pdf       = Pdf::loadView('invoice.pdf', compact('invoice'));
        $directory = public_path('invoices');
        $fileName  = $invoice->id . '_' . time() . '.pdf';

        if (!$pdf->save($directory . '/' . $fileName)) {
            $this->failed('Failed to save invoice to disk.');
            return;
        }

        $invoice->files()->create([
            'file_name' => $fileName,
            'file_size' => filesize($directory . '/' . $fileName),
        ]);
    }

    /**
     * The job failed to process.
     *
     * @return void
     */
    public function failed($why = null)
    {
        $this->invoice->creator->notify(
            new InvoiceGenerationFailureNotification($this->invoice, $why)
        );
        
        Log::error('Invoice generation failed for invoice: ' . $this->invoice->id);
        
        report(new \Exception('Invoice generation failed for invoice: ' . $this->invoice->id . ' - ' . $why));
    }
}
