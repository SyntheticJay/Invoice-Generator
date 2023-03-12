@extends('layouts.app')
@section('title', isset($vatRule) ? 'Edit' : 'Create' . ' VAT Rule')

@section('content')
    <div class="container">
        <h1 class="text-muted">
            @if (isset($vatRule))
                Edit VAT Rule {{ $vatRule->name }}
            @else
                Create VAT Rule
            @endif
        </h1>
        <hr/>
        @if (isset($vatRule))
            <form method="POST" action="{{ route('vatrule.update', $vatRule->id) }}">
            @csrf
            @method('PUT')
        @else
            <form method="POST" action="{{ route('vatrule.store') }}">
            @csrf
        @endif
            <div class="row">
                <div class="col">
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $vatRule->name ?? old('name') }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ $vatRule->description ?? old('description') }}">
                    </div>
                    <div class="form-group mb-2">
                        <label for="percentage" class="form-label">Percentage (%)</label>
                        <input type="text" class="form-control @error('percentage') is-invalid @enderror" id="percentage" name="percentage" value="{{ $vatRule->percentage ?? old('percentage') }}" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="vat_code" class="form-label">VAT Code</label>
                        <input type="text" class="form-control @error('vat_code') is-invalid @enderror" id="vat_code" name="vat_code" value="{{ $vatRule->vat_code ?? old('vat_code') }}">
                    </div>
                    <div class="form-group mb-2">
                        <label for="nominal_vat" class="form-label">VAT Nominal</label>
                        <input type="text" class="form-control @error('nominal_vat') is-invalid @enderror" id="nominal_vat" name="nominal_vat" value="{{ $vatRule->nominal_vat ?? old('nominal_vat') }}">
                    </div>
                    <a href="{{ route('vatrule.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
