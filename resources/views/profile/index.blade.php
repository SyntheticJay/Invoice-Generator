@extends('layouts.app')
@section('title', 'Your Profile')

@section('content')
    <div class="container">
        <h1 class="text-muted">
            Your Profile
        </h1>
        <hr/>
        <div class="row">
            <div class="col">
                <form method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
            <div class="col">
                <div class="mt-3">
                    <h3 class="text-muted">Sessions</h3>
                    <hr/>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">IP Address</th>
                                    <th scope="col">User Agent</th>
                                    <th scope="col">Last Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->sessions as $login)
                                    <tr>
                                        <td>{{ $login->ip_address }}</td>
                                        <td data-tooltip="{{ $login->user_agent }}">{{ Str::limit($login->user_agent, 45, $end='...') }}</td>
                                        <td>{{ $login->last_activity->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection