@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Create Warehouse</h3>
            <a href="{{ route('warehouses.index') }}" class="btn btn-info btn-sm float-right">Back</a>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('warehouses.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Warehouse Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="user_id" class="form-label">User</label>
                    <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Create Warehouse</button>
            </form>
        </div>
    </div>
@endsection
