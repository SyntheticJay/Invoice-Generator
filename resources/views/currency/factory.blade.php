@extends('layouts.app')
@section('title', isset($currency) ? 'Edit' : 'Create' . ' Currency')

@section('content')
    <div class="container">
        <h1 class="text-muted">
            @if (isset($currency))
                Edit Currency {{ $currency->name }}
            @else
                Create Currency
            @endif
        </h1>
        <hr/>
        @if (isset($currency))
            <form method="POST" action="{{ route('currency.update', $currency->id) }}">
            @csrf
            @method('PUT')
        @else
            <form method="POST" action="{{ route('currency.store') }}">
            @csrf
        @endif
            <div class="row">
                <div class="col">
                    <div class="form-group mb-2">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ $currency->code ?? old('code') }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $currency->name ?? old('name') }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="exchange_rate" class="form-label">Exchange Rate</label>
                        <input type="text" class="form-control @error('exchange_rate') is-invalid @enderror" id="exchange_rate" name="exchange_rate" value="{{ $currency->exchange_rate ?? old('exchange_rate') }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="symbol" class="form-label">Symbol</label>
                        <input type="text" class="form-control @error('symbol') is-invalid @enderror" id="symbol" name="symbol" value="{{ $currency->symbol ?? old('symbol') }}" required>
                    </div>
                    <a href="{{ route('currency.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
