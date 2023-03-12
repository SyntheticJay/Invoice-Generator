@extends('layouts.app')
@section('title', 'View Currencies')

@section('content')
    <div class="container">
        <h1 class="text-muted float-start">Currencies</h1>
        <a href="{{ route('currency.create') }}" class="btn btn-primary float-end m-auto">Create New Currency</a>
        <div class="clearfix"></div>
        <hr/>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Name</th>
                        <th scope="col">Exchange Rate</th>
                        <th scope="col">Symbol</th>
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if ($currencies->count() == 0)
                        <tr>
                            <td colspan="7" class="text-center">No currencies found</td>
                        </tr>
                    @else
                        @foreach ($currencies as $currency)
                            <tr @if($currency->is_archived) class="table-danger" @endif>
                                <td>{{ $currency->code }}</td>
                                <td>{{ $currency->name }}</td>
                                <td>{{ $currency->exchange_rate }}</td>
                                <td>{{ $currency->symbol }}</td>
                                <td>{{ $currency->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $currency->updated_at->format('d/m/Y H:i:s') }}</td>
                                <td class="text-end">
                                    <a data-tooltip="Edit this customer" href="{{ route('currency.edit', $currency->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @if ($currency->is_archived)
                                        <a href="{{ route('currency.unarchive', $currency->id) }}">
                                            <button data-tooltip="Unarchive this customer" type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-archive"></i>
                                            </button>
                                        </a>
                                    @else
                                        <form action="{{ route('currency.destroy', $currency->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button data-tooltip="Archive this customer" type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection