@extends('layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Edit User: {{ $user->name }}</h3>
        </div>

        <div class="card-body">
            @if (session('update'))
                <div class="alert alert-info">{{ session('update') }}</div>
            @endif

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">User Name</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">Select a Role</option>
                        @foreach ($roles as $role)
                            @if ($user->role_id == $role->id)
                                <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                            @else
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update User</button>
            </form>
        </div>
    </div>
@endsection
