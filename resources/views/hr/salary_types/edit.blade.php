@extends('layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Edit Salary Type: {{ $salary_type->name }}</h3>
        </div>

        <div class="card-body">
            @if (session('update'))
                <div class="alert alert-info">{{ session('update') }}</div>
            @endif

            <form action="{{ route('salary_types.update', $salary_type->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Salary Type Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" value="{{ old('name', $salary_type->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Salary Type</button>
            </form>
        </div>
    </div>
@endsection
