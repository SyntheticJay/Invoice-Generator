@extends('layouts.app')
@section('title', 'View Invoice')

@section('content')
    <div class="container">
        <h1>
            @if ($invoice->is_archived)
                <span class="text-danger">
                    <i class="fa fa-archive"></i>    
                    Archived
                </span>
            @endif
            Invoice to {{ $invoice->customer->name }} ({{ $invoice->invoice_number }})
        </h1>
        <hr/>
        <div class="row">
            <div class="col">
                <table class="table detail-table">
                    <tbody>
                        <tr>
                            <td>From</td>
                            <td>{{ $invoice->invoice_from }}</td>
                        </tr>
                        <tr>
                            <td>To</td>
                            <td>
                               {{ $invoice->customer->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>Currency</td>
                            <td>{{ $invoice->currency->symbol }} {{ $invoice->currency->code }}</td>
                        </tr>
                        <tr>
                            <td>Invoice Number</td>
                            <td>{{ $invoice->invoice_number }}</td>
                        </tr>
                        <tr>
                            <td>Invoice Date</td>
                            <td>{{ $invoice->invoice_date->format('d/m/Y') }}</td>
                        </tr>
                    </tbody>
                </table>
                <!-- invoice items -->
                <h3 class="text-muted">Items</h3>
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th class="w-50">Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>VAT</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($invoice->lineItems->count() == 0)
                            <tr>
                                <td colspan="4" class="text-center">No items</td>
                            </tr>
                        @else
                            @foreach ($invoice->lineItems as $item)
                                <tr>
                                    <td>{{ $item->description }}</td>
                                    <td class="text-right">{{ $item->quantity }}</td>
                                    <td class="text-right">{{ $invoice->currency->symbol }} {{ $item->formattedUnitPrice }}</td>
                                     <td class="text-right">{{ $invoice->currency->symbol }} {{ $item->formattedVatValue }}</td>
                                    <td class="text-right">{{ $invoice->currency->symbol }} {{ $item->formattedTotal }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="text-end total-summary mb-2">
                    <div class="total-summary-container">
                        <div class="block">
                            <label for="subtotal">Subtotal</label>
                            
                            <span id="subtotal">
                                {{ $invoice->currency->symbol }}
                                {{ $invoice->formattedSubTotal }}
                            </span>
                        </div>
                        <div class="block">
                            <label for="vat">VAT</label>

                            <span id="vat">
                                {{ $invoice->currency->symbol }}
                                {{ $invoice->formattedVatTotal }}
                            </span>
                        </div>
                        <div class="block">
                            <label for="total">Total</label>

                            <span id="total">
                                {{ $invoice->currency->symbol }}
                                {{ $invoice->formattedTotal }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="action-btns">
                    <a href="{{ route('invoice.edit', $invoice->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('invoice.download', $invoice->id) }}" class="btn btn-primary">Download PDF</a>

                    @if ($invoice->files->count() > 0)
                        <a href="{{ route('invoice.resend', $invoice->id) }}" class="btn btn-primary">Re-send Email</a>                  
                    @endif
                </div>
            </div>
            <div class="col">
                @if ($invoice->files->count() == 0)
                    <h3 class="text-center">No Preview</h3>                  
                @else    
                    <embed src="{{ asset('invoices/' . $invoice->files->last()->file_name) }}" type="application/pdf" width="100%" height="600px" />
                @endif
            </div>
        </div>
    </div>
@endsection