@extends('layouts.app')
@section('title', isset($customer) ? 'Edit' : 'Create' . ' Customer')

@section('content')
    <div class="container">
        <h1 class="text-muted">
            @if (isset($customer))
                Edit Customer {{ $customer->name }}
            @else
                Create Customer
            @endif
        </h1>
        <hr/>
        @if (isset($customer))
            <form method="POST" action="{{ route('customer.update', $customer->id) }}">
            @csrf
            @method('PUT')
        @else
            <form method="POST" action="{{ route('customer.store') }}">
            @csrf
        @endif
            <div class="row">
                <div class="col">
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $customer->name ?? old('name') }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $customer->email ?? old('email') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $customer->phone ?? old('phone') }}">
                    </div>
                    <a href="{{ route('customer.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                <div class="col">
                    <div class="form-group mb-2">
                        <label for="addr_line_1" class="form-label">Address Line 1</label>
                        <input type="text" class="form-control @error('addr_line_1') is-invalid @enderror" id="addr_line_1" name="addr_line_1" value="{{ $customer->addr_line_1 ?? old('addr_line_1') }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="addr_line_2" class="form-label">Address Line 2</label>
                        <input type="text" class="form-control @error('addr_line_2') is-invalid @enderror" id="addr_line_2" name="addr_line_2" value="{{ $customer->addr_line_2 ?? old('addr_line_2') }}">
                    </div>
                    <div class="form-group mb-2">
                        <label for="postcode" class="form-label">Postcode</label>
                        <input type="text" class="form-control @error('postcode') is-invalid @enderror" id="postcode" name="postcode" value="{{ $customer->postcode ?? old('postcode') }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="city" class="form-label">City / Town</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ $customer->city ?? old('city') }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="county" class="form-label">State / Province / County</label>
                        <input type="text" class="form-control @error('county') is-invalid @enderror" id="county" name="county" value="{{ $customer->county ?? old('county') }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="country_id" class="form-label">Country</label>
                        <select class="form-control @error('country_id') is-invalid @enderror" id="country_id" name="country_id" required>
                            <option value="">Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @selected(
                                    isset($customer) && $customer->country_id == $country->id || old('country') == $country->id
                                )>{{ $country->name }}</option>
                            @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
