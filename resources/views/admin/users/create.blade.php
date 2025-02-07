@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Create User</h3>
            <a href="{{ route('users.index') }}" class="btn btn-info btn-sm float-right">Back</a>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">User Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        id="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        id="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-control @error('role') is-invalid @enderror">
                        <option value="">Select a Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Create User</button>
            </form>
        </div>
    </div>
@endsection
