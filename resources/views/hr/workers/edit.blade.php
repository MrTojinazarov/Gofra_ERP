@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Edit Worker: {{ $worker->name }}</h3>
            <a href="{{ route('workers.index') }}" class="btn btn-info btn-sm float-right">Back</a>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('workers.update', $worker->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label">User</label>
                        <select class="form-select" name="user_id" id="user_id">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $worker->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="section_id" class="form-label">Section</label>
                        <select class="form-select" name="section_id" id="section_id">
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}"
                                    {{ $worker->section_id == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}</option>
                            @endforeach
                        </select>
                        @error('section_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                            id="address" value="{{ old('address', $worker->address) }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                            id="phone" value="{{ old('phone', $worker->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="text" class="form-control @error('salary') is-invalid @enderror" name="salary"
                            id="salary" value="{{ old('salary', $worker->salary) }}">
                        @error('salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="salary_type" class="form-label">Salary Type</label>
                        <select name="salary_type_id" class="form-control">
                            @foreach ($salary_types as $salary)
                                @if ($salary->id == $worker->salary_type_id)
                                    <option value="{{ $salary->id }}" class="form-control" selected>
                                        {{ $salary->name }}</option>
                                @endif
                                <option value="{{ $salary->id }}" class="form-control">{{ $salary->name }}</option>
                            @endforeach
                        </select>
                        @error('salary_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="month_time" class="form-label">Month Time</label>
                        <input type="number" class="form-control @error('month_time') is-invalid @enderror"
                            name="month_time" id="month_time" value="{{ old('month_time', $worker->month_time) }}">
                        @error('month_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                            name="start_time" id="start_time" value="{{ old('start_time', $worker->start_time) }}">
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time"
                            id="end_time" value="{{ old('end_time', $worker->end_time) }}">
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Update Worker</button>
            </form>
        </div>
    </div>
@endsection
