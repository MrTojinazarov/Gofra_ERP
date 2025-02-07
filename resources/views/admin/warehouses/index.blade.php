@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Warehouses List</h3>
            <a href="{{ route('warehouses.create') }}" class="btn btn-primary btn-sm float-right">Create warehouse</a>
        </div>

        <div class="card-body">
            @if (session('create'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('create') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('delete'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('delete') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('update'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('update') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($warehouses as $warehouse)
                            <tr>
                                <th>{{ $warehouse->id }}</th>
                                <td>{{ $warehouse->name }}</td>
                                <td>{{ $warehouse->user->name }}</td>
                                <td>
                                    <form action="{{ route('warehouses.status', $warehouse->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if ($warehouse->status == 1)
                                            <input type="hidden" name="id" value="{{ $warehouse->id }}">
                                            <input type="hidden" name="active" value="0">
                                            <button class="badge bg-success">Active</button>
                                        @else
                                            <input type="hidden" name="id" value="{{ $warehouse->id }}">
                                            <input type="hidden" name="active" value="1">
                                            <button class="badge bg-danger">Inactive</button>
                                        @endif
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <form action="{{ route('warehouses.show', $warehouse->id) }}" method="GET"
                                            class="mr-2">
                                            <button type="submit" class="btn btn-info btn-sm"><i
                                                    class="fas fa-eye"></i></button>
                                        </form>
                                        <a href="{{ route('warehouses.edit', $warehouse->id) }}"
                                            class="btn btn-warning btn-sm mr-2">Edit</a>
                                        <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
