@extends('layouts.app')
@section('title', 'View Customers')

@section('content')
    <div class="container">
        <h1 class="text-muted float-start">Customers</h1>
        <a href="{{ route('customer.create') }}" class="btn btn-primary float-end m-auto">Create New Customer</a>
        <div class="clearfix"></div>
        <hr/>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Country</th>
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if ($customers->count() == 0)
                        <tr>
                            <td colspan="7" class="text-center">No customers found</td>
                        </tr>
                    @else
                        @foreach ($customers as $customer)
                            <tr @if($customer->is_archived) class="table-danger" @endif>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->country->name }}</td>
                                <td>{{ $customer->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $customer->updated_at->format('d/m/Y H:i:s') }}</td>
                                <td class="text-end">
                                    <a data-tooltip="Edit this customer" href="{{ route('customer.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @if ($customer->is_archived)
                                        <a href="{{ route('customer.unarchive', $customer->id) }}">
                                            <button data-tooltip="Unarchive this customer" type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-archive"></i>
                                            </button>
                                        </a>
                                    @else
                                        <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline">
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