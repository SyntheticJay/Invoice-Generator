@extends('layouts.app')
@section('title', 'VAT Rules')

@section('content')
    <div class="container">
        <h1 class="text-muted float-start">VAT Rules</h1>
        <a href="{{ route('vatrule.create') }}" class="btn btn-primary float-end m-auto">Create New VAT Rule</a>
        <div class="clearfix"></div>
        <hr/>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Percentage %</th>
                        <th scope="col">VAT Code</th>
                        <th scope="col">VAT Nominal</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if ($vatRules->count() == 0)
                        <tr>
                            <td colspan="8" class="text-center">No VAT Rules found</td>
                        </tr>
                    @else
                        @foreach ($vatRules as $vatRule)
                            <tr @if($vatRule->is_archived) class="table-danger" @endif>
                                <td>{{ $vatRule->name }}</td>
                                <td>{{ $vatRule->description }}</td>
                                <td>{{ $vatRule->percentage }}%</td>
                                <td>{{ $vatRule->vat_code }}</td>
                                <td>{{ $vatRule->nominal_vat }}</td>
                                <td>{{ $vatRule->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $vatRule->updated_at->format('d/m/Y H:i:s') }}</td>
                                <td class="text-end">
                                    <a data-tooltip="Edit this VAT rule" href="{{ route('vatrule.edit', $vatRule->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @if ($vatRule->is_archived)
                                        <a href="{{ route('vatrule.unarchive', $vatRule->id) }}">
                                            <button data-tooltip="Unarchive this VAT Rule" type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-archive"></i>
                                            </button>
                                        </a>
                                    @else
                                        <form action="{{ route('vatrule.destroy', $vatRule->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button data-tooltip="Archive this VAT Rule" type="submit" class="btn btn-danger btn-sm">
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