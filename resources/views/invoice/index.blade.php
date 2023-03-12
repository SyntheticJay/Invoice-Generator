@extends('layouts.app')
@section('title', 'Invoices')

@section('content')
    <div class="container">
        <h1 class="text-muted float-start">Invoices</h1>
        <a href="{{ route('invoice.create') }}" class="btn btn-primary float-end m-auto">Create New Invoice</a>
        <div class="clearfix"></div>
        <hr/>
        <table class="table table-striped">
            <thead class="table-dark">
                <th scope="col">Customer</th>
                <th scope="col">Currency</th>
                <th scope="col">Subtotal</th>
                <th scope="col">VAT</th>
                <th scope="col">Total</th>
                <th scope="col">Created</th>
                <th scope="col">Last Updated</th>
                <th scope="col"></th>
            </thead>
            <tbody>
                @if ($invoices->count() == 0)
                    <tr>
                        <td colspan="8" class="text-center">No invoices found.</td>
                    </tr>
                @else
                    @foreach ($invoices as $invoice)
                        <tr @if($invoice->is_archived) class="table-danger" @endif data-id="{{ $invoice->id }}">
                            <td>{{ $invoice->customer->name }}</td>
                            <td>{{ $invoice->currency->symbol }} {{ $invoice->currency->code }}</td>
                            <td class="text-right">{{ $invoice->currency->symbol }}{{ $invoice->formattedSubTotal }}</td>
                            <td class="text-right">{{ $invoice->currency->symbol }}{{ $invoice->formattedVatTotal }}</td>
                            <td class="text-right">{{ $invoice->currency->symbol }}{{ $invoice->formattedTotal }}</td>
                            <td data-tooltip="{{ $invoice->created_at }}">{{ $invoice->created_at->format('d/m/Y H:i:s') }}</td>
                            <td data-toolip="{{ $invoice->updated_at }}">{{ $invoice->updated_at->format('d/m/Y H:i:s') }}</td>
                            <td class="text-end">
                                <a data-tooltip="View this invoice" href="{{ route('invoice.show', $invoice->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a data-tooltip="Edit this invoice" href="{{ route('invoice.edit', $invoice->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form data-tooltip="Remove this invoice" action="{{ route('invoice.destroy', $invoice->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection