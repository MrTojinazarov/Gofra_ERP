@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Materials List</h3>
            <a href="{{ route('revenues.index') }}" class="btn btn-info btn-sm float-right">Back</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity & unit</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $material)
                            <tr>
                                <th>{{ $material->id }}</th>
                                <td>{{ $material->material->name }}</td>
                                <td>{{ number_format($material->price) }} so'm</td>
                                <td>{{ number_format($material->quantity) }}
                                    {{ $material->unit }}</td>
                                <td>{{ number_format($material->total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
