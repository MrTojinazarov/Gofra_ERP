@extends('layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Create Salary Type</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('salary_types.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Salary Type Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Create Salary Type</button>
            </form>
        </div>
    </div>
@endsection
