<?php

namespace App\Http\Controllers\Invoice;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Currency\Currency;
use App\Models\Invoice\Invoice;
use App\Models\Customer\Customer;
use App\Models\VATRule\VATRule;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Http\Requests\Invoice\CreateInvoiceRequest;
use App\Http\Requests\Invoice\Ajax\InvoiceCheckRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = auth()->user()->invoices()
                        ->orderBy('created_at', 'desc')    
                        ->get();

        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers  = auth()->user()->customers()->where('is_archived', false)->get();
        $currencies = auth()->user()->currencies()->where('is_archived', false)->get();
        $vatRules   = auth()->user()->vatRules()->where('is_archived', false)->get();

        return view('invoice.factory', compact('customers', 'currencies', 'vatRules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateInvoiceRequest $request)
    {
        $validated = collect($request->validated());
        
        try {
            $invoice = auth()->user()->invoices()->create($validated->except('line_items')
                ->put('user_id', auth()->id())
                ->put('invoice_from', auth()->user()->name)
                ->toArray()
            );
            
            $invoice->lineItems()->createMany($validated->get('line_items'));
            
            $invoice->generate();

            if ($validated->get('send_email')) { 
                $invoice->email();
            }

            return redirect()->route('invoice.show', $invoice->id)->with('success', 'Invoice created successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Invoice creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return view('invoice.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $customers  = auth()->user()->customers()->where('is_archived', false)->get();
        $currencies = auth()->user()->currencies()->where('is_archived', false)->get();
        $vatRules   = auth()->user()->vatRules()->where('is_archived', false)->get();

        return view('invoice.factory', compact('invoice', 'customers', 'currencies', 'vatRules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateInvoiceRequest  $request
     * @param  \App\Models\Invoice\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        try {
            $validated = collect($request->validated());
            $lineItems = collect($validated->get('line_items'));
            
            $invoice->update($validated->except('line_items')->toArray());
            
            $invoice->lineItems()->delete();

            $invoice->lineItems()->createMany($lineItems->toArray());

            $invoice->generate();

            if ($validated->get('resend_email')) {
                $invoice->email();
            }

            return redirect()->route('invoice.show', $invoice->id)->with('success', 'Invoice updated successfully');
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Invoice update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->delete();
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Invoice delete failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Invoice deleted successfully');
    }

    /**
     * Download the last generated invoice.
     *
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, Invoice $invoice)
    {
        $last = $invoice->files->last();

        if (!$last) {
            return redirect()->back()->with('error', 'No invoice file found.');
        }

        return response()->download(public_path('invoices/' . $last->file_name));
    }

    /**
     * Resend the invoice email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request, Invoice $invoice)
    {
        $invoice->email();

        return redirect()->back()->with('success', 'Attempted to resend invoice email. If something fails, check your notifications.');
    }
}
