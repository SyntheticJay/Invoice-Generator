<!doctype html>
<html lang="en">
    <head>
        <title>{{ $invoice->invoice_number }}</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        
        <style type="text/css">
            .line {
                border-bottom: 1px solid #000;
                margin: 0;
                padding: 0;
                width: 100%;
            }
            .line label {
                display: inline-block;
                font-size: 12px;
                font-weight: bold;
                margin: 0;
                padding: 0;
                width: 100%;
            }
            .line span {
                display: inline-block;
                font-size: 12px;
                margin: 0;
                padding: 0;
                width: 100%;
            }
            table thead {
                background-color: #000;
                color: #fff;
            }
            section {
                margin-top: 15px;
            }
            .banner {
                background-color: #000;
                color: #fff;
                padding: 10px;
            }
            .customer-name {
                font-size: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <header id="invoice-header">
                <div class="pull-left">
                    <h1 class="text-muted customer-name">
                        {{ $invoice->customer->name }}
                    </h1>
                    <address>
                        {{ $invoice->customer->city }}, {{ $invoice->customer->county }} {{ $invoice->customer->postcode }}<br>
                        {{ $invoice->customer->phone }}<br>
                        {{ $invoice->customer->email }}
                    </address>
                    <div class="line">
                        <label>Currency</label>
                        <span>{{ $invoice->currency->symbol }} {{ $invoice->currency->code }}</span>
                    </div>
                </div>
                <div class="pull-right">
                    <h1 class="text-muted">
                    Invoice
                </h1>
                <section id="invoice-info">
                    <div class="line">
                        <label>Invoice Number</label>
                        <span>{{ $invoice->invoice_number }}</span>
                    </div>
                    <div class="line">
                        <label>Invoice Date</label>
                        <span>{{ $invoice->invoice_date }}</span>
                    </div>
                </section>
            </header>
            <div class="clearfix"></div>
            <section id="line-items">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Description</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($invoice->lineItems->count() == 0)
                            <tr>
                                <td colspan="4" class="text-center">No items found.</td>
                            </tr>
                        @else
                            @foreach ($invoice->lineItems as $item)
                                <tr>
                                    <td>{{ $item->description }}</td>
                                    <td class="text-right">{{ $item->quantity }}</td>
                                    <td class="text-right">{{ $invoice->currency->symbol }}{{ $item->unit_price }}</td>
                                    <td class="text-right">{{ $invoice->currency->symbol }}{{ $item->total }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </section>
            <div class="clearfix"></div>
            <section id="invoice-totals">
                <div class="pull-right">
                    <div class="line">
                        <label>Total</label>
                        <span>{{ $invoice->currency->symbol }}{{ $invoice->formattedTotal }}</span>
                    </div>
                </div>
            </section>
            <div class="clearfix"></div>
        </div>
    </body>
</html>