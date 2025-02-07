@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Revenue Import</h3>
            <a href="{{ route('revenues.index') }}" class="btn btn-info btn-sm float-right">Back</a>
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('revenues.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="warehouse_id" class="form-label">Warehouse</label>
                    <select class="form-control @error('warehouse_id') is-invalid @enderror" name="warehouse_id"
                        id="warehouse_id">
                        <option value="">Select a Warehouse</option>
                        @foreach ($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                    @error('warehouse_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label">Upload Excel File</label>
                    <input type="file" class="form-control @error('file') is-invalid @enderror" name="file"
                        id="file" accept=".xlsx, .csv">
                    @error('file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let warehouseSelect = document.getElementById('warehouse');
            let companyInput = document.getElementById('company');

            warehouseSelect.addEventListener('change', function() {
                let selectedOption = warehouseSelect.options[warehouseSelect.selectedIndex];
                companyInput.value = selectedOption.text;
            });
        });
    </script>
@endsection
