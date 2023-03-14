@extends('layouts.app')
@section('title', isset($invoice) ? 'Edit' : 'Create' . ' Invoice')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col px-5">
                <h1 class="text-muted">
                    {{ isset($invoice) ? 'Edit' : 'Create' }} Invoice
                </h1>
                <hr/>
                @if (isset($invoice))
                    <form method="POST" action="{{ route('invoice.update', $invoice) }}">
                    @csrf
                    @method('PUT')
                @else
                    <form method="POST" action="{{ route('invoice.store') }}">
                    @csrf
                @endif
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="customer_id">Customer</label>
                                        </div>
                                        <div class="col text-end">
                                             <small class="text-end">
                                                <a href="{{ route('customer.create') }}">Create</a>
                                            </small>
                                        </div>
                                    </div>
                                    <select class="form-control @error('customer_id') is-invalid @enderror" id="customer_id" name="customer_id">
                                        <option value="placeholder">Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" 
                                                @selected(
                                                    isset($invoice) ? $invoice->customer_id == $customer->id : old('customer_id') == $customer->id
                                                )
                                            >{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label for="currency_id">Currency</label>
                                        </div>
                                        <div class="col text-end">
                                             <small class="text-end">
                                                <a href="{{ route('currency.create') }}">Create</a>
                                            </small>
                                        </div>
                                    </div>
                                    <select class="form-control @error('currency_id') is-invalid @enderror" id="currency_id" name="currency_id">
                                        <option value="placeholder">Select Currency</option>
                                        @foreach($currencies as $currency)
                                            <option data-symbol="{{ $currency->symbol }}" value="{{ $currency->id }}"
                                                @selected(
                                                    isset($invoice) ? $invoice->currency_id == $currency->id : old('currency_id') == $currency->id
                                                )
                                            >{{ $currency->name }} ({{ $currency->symbol }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col form-group">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <label for="invoice_number">Invoice Number</label>
                                        </div>
                                        <div class="col-1 text-end">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" id="invoice_number" name="invoice_number" value="{{ 
                                        isset($invoice) ? $invoice->invoice_number : old('invoice_number')
                                    }}">
                                </div>
                                  <div class="col form-group">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <label for="reference">Invoice Reference</label>
                                        </div>
                                        <div class="col-1 text-end">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control @error('reference') is-invalid @enderror" id="reference" name="reference" value="{{ 
                                        isset($invoice) ? $invoice->reference : old('reference')
                                    }}">
                                </div>
                                <div class="col form-group">
                                    <label for="invoice_date">Invoice Date</label>
                                    <input type="text" autocomplete="off" class="form-control datepicker @error('invoice_date') is-invalid @enderror" id="invoice_date" name="invoice_date" value="{{ 
                                        isset($invoice) ? $invoice->invoice_date->format('d/m/Y') : old('invoice_date')
                                    }}">
                                </div>           
                            </div>
                            <div class="row mt-3">
                                <h3 class="text-muted">Line Items</h3>
                                <hr/>
                                <div class="col">
                                    <table class="table line-items-table table table-striped">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col" style="width: 40%;">Item</th>
                                                <th scope="col" style="width: 20%;">VAT</th>
                                                <th scope="col" style="width: 10%;">Quantity</th>
                                                <th scope="col" style="width: 15%;">Price</th>
                                                <th scope="col" style="width: 15%;">Total</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($invoice))
                                                @foreach($invoice->lineItems as $lineItem)
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" name="line_items[{{ $loop->index }}][description]" value="{{ $lineItem->description }}" required>
                                                        </td>
                                                        <td>
                                                            <select class="form-control" name="line_items[{{ $loop->index }}][vat_id]">
                                                                <option value="placeholder">Select Rate</option>
                                                                @foreach($vatRules as $vatRule)
                                                                    <option data-percentage="{{ $vatRule->percentage }}" value="{{ $vatRule->id }}" 
                                                                        @selected($lineItem->vat_id == $vatRule->id)
                                                                    >{{ $vatRule->name }} ({{ $vatRule->percentage }}%)</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control" name="line_items[{{ $loop->index }}][quantity]" value="{{ $lineItem->quantity }}" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="line_items[{{ $loop->index }}][unit_price]" value="{{ $lineItem->unit_price }}" required>
                                                        </td>
                                                        <td class="total-col text-end">
                                                            <label class="currency-symbol"></label>
                                                            <span class="total"></span>
                                                        </td>
                                                        <td class="text-end m-auto">
                                                            <button data-tooltip="Remove this line" type="button" class="btn btn-sm btn-danger remove-line">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">
                                                    <button data-tooltip="Create new line item" type="button" class="btn btn-sm btn-primary add-new-line">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button data-tooltip="Clear all line items" type="button" class="btn btn-sm btn-danger clear-all">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="text-end total-summary mb-2">
                                <div class="total-summary-container">
                                    <div class="block">
                                        <label for="subtotal">Subtotal</label>
                                        
                                        <label class="currency-symbol"></label>
                                        <span id="subtotal"></span>
                                    </div>
                                    <div class="block">
                                        <label for="vat">VAT</label>

                                        <label class="currency-symbol"></label>
                                        <span id="vat"></span>
                                    </div>
                                    <div class="block">
                                        <label for="total">Total</label>

                                        <label class="currency-symbol"></label>
                                        <span id="total"></span>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="form-check">
                                @if (isset($invoice))
                                    <input type="checkbox" class="form-check-input" id="resend_email" name="resend_email" value="1" />
                                    <label class="form-check-label" for="resend_email">Resend Invoice to customer?</label>
                                @else
                                    <input type="checkbox" class="form-check-input" id="send_email" name="send_email" value="1" />
                                    <label class="form-check-label" for="send_email">Send Invoice to customer?</label>
                                @endif
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('invoice.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col px-5">
                <embed id="preview">
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="module">
        $(() => {
            datepicker('#invoice_date', {
                format: "d/m/Y",
                autoHide: true,
                formatter: (input, date, instance) => {
                    input.value = date.toLocaleDateString('en-GB');
                },
                onHide: (instance) => {
                    $('#invoice_date').trigger('change');
                }
            });

            const emptyRow = () => {
                return `
                    <tr data-noresult>
                        <td colspan="6" class="text-center text-muted">No line items</td>
                    </tr>
                `;
            }

            const setTotals = (subtotal, vat, total) => {
                $('#subtotal').text(number_format(subtotal, 2));
                $('#vat').text(number_format(vat, 2));
                $('#total').text(number_format(total, 2));
            };

            const reprocess = () => {
                $('#currency_id').trigger('change');
                
                if ($('.line-items-table tbody tr').length === 0) {
                    $('.line-items-table tbody').html(emptyRow());
                    setTotals(0, 0, 0);
                    return;
                } else {
                    for (let i = 0; i < $('.line-items-table tbody tr').length; i++) {
                        const row = $('.line-items-table tbody tr').eq(i);
                    
                        row.find('input, select').each((index, element) => {
                            const name = $(element).attr('name');
                            const newName = name.replace(/\d+/, i);
                            $(element).attr('name', newName);
                        });
                    }
                }

                let subtotal = 0, vat = 0, total = 0;

                $('.line-items-table tbody tr').each((index, row) => {
                    let quantity      = $(row).find('input[name^="line_items"][name$="[quantity]"]').val();
                    let price         = $(row).find('input[name^="line_items"][name$="[unit_price]"]').val();
                    let vatPercentage = $(row).find('select[name^="line_items"][name$="[vat_id]"] option:selected').data('percentage');
                    
                    if (quantity === '' || price === '' || vatPercentage === undefined) {
                        $(row).find('.total').text('??');
                        return;
                    }

                    quantity      = parseFloat(quantity);
                    price         = parseFloat(price);
                    vatPercentage = parseFloat(vatPercentage);

                    let lineTotal = quantity * price;
                    let lineVat   = lineTotal * (vatPercentage / 100);
                    
                    subtotal += lineTotal;
                    vat      += lineVat;
                    total    += lineTotal + lineVat;
                    
                    $(row).find('.total').text(number_format(lineTotal + lineVat, 2));
                });

                setTotals(subtotal, vat, total);
            };

            $('#currency_id').on('change', (event) => {
                const currency = $(event.target).val();

                if (currency == 'placeholder') {
                    $('.currency-symbol').text('');
                    return;
                }

                $('.currency-symbol').text(
                    $(event.target).find(`option[value="${currency}"]`).data('symbol')
                );
            });

            $('.line-items-table tbody').on('change', 'input, select', (event) => {
                reprocess();
            });

            $('.clear-all').on('click', (event) => {
                $('.line-items-table tbody tr').remove();
                reprocess();
            });

            $('.remove-line').on('click', (event) => {
                $(event.target).closest('tr').remove();
                reprocess();
            });

            $('.add-new-line').on('click', (event) => {
                if ($('.line-items-table tbody tr').length === 1 && $('.line-items-table tbody tr').attr('data-noresult') !== undefined) {
                    $('.line-items-table tbody tr').remove();

                    $('.line-items-table tbody').html(`
                        <tr>
                            <td>
                                <input type="text" name="line_items[0][description]" class="form-control" required>
                            </td>
                            <td>
                                <select name="line_items[0][vat_id]" class="form-control" required>
                                    <option value="placeholder" disabled selected>Select VAT</option>
                                    @foreach ($vatRules as $vatRule)
                                        <option value="{{ $vatRule->id }}" data-percentage="{{ $vatRule->percentage }}">
                                            {{ $vatRule->name }} ({{ $vatRule->percentage }}%)
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="line_items[0][quantity]" class="form-control" required>
                            </td>
                            <td>
                                <input type="number" name="line_items[0][unit_price]" class="form-control" required>
                            </td>
                            <td>
                                <span class="currency-symbol"></span>
                                <span class="total">0.00</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger remove-line">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `);

                    reprocess();
                    return;
                }

                const lineItem = $('.line-items-table tbody tr:last-child');
                const newRow   = lineItem.clone();

                newRow.find('input').val('');
                newRow.find('select').val('placeholder');
                newRow.find('.total').text('0.00');

                newRow.find('input, select').each((index, element) => {
                    const name    = $(element).attr('name');
                    const newName = name.replace(/\d+/, $('.line-items-table tbody tr').length);
                    $(element).attr('name', newName);
                });

                lineItem.after(newRow);
                reprocess();
            });

            $('form').submit((event) => {
                if ($('.line-items-table tbody tr').length === 0 || $('.line-items-table tbody tr').attr('data-noresult') !== undefined) {
                    event.preventDefault();
                    toastr.error("You must have at least one line item to save an invoice");
                    return;
                }

                let passed = true;

                $('.line-items-table tbody tr').each((index, row) => {
                    const quantity  = $(row).find('input[name^="line_items"][name$="[quantity]"]').attr('name', `line_items[${index}][quantity]`);
                    const unitPrice = $(row).find('input[name^="line_items"][name$="[unit_price]"]').attr('name', `line_items[${index}][unit_price]`);
                    const vatId     = $(row).find('select[name^="line_items"][name$="[vat_id]"]').attr('name', `line_items[${index}][vat_id]`);
                 
                    if (
                        (isNaN(quantity.val()) || isNaN(unitPrice.val())) || 
                        (quantity.val() === '' || unitPrice.val() === '')
                    ) {
                        $(row).addClass('table-danger');
                        passed = false;
                    }

                    if (vatId.val() === 'placeholder' || !vatId.val()) {
                        $(row).addClass('table-danger');
                        passed = false;
                    }
                });

                if (!passed) {
                    event.preventDefault();
                    toastr.error("There are one or more invalid line items. Please check the values and try again");
                    return;
                }
            });

            reprocess();
        });
    </script>
@endsection