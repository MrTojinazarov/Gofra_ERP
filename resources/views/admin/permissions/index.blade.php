@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Permissions List</h3>
        </div>

        <div class="card-body">
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
                            <th>Key</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Group</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <th>{{ $permission->id }}</th>
                                <td>{{ $permission->key }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    <form action="{{ route('permissions.status', $permission->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if ($permission->status == 1)
                                            <input type="hidden" name="id" value="{{ $permission->id }}">
                                            <input type="hidden" name="active" value="0">
                                            <button class="badge bg-success">Active</button>
                                        @else
                                            <input type="hidden" name="id" value="{{ $permission->id }}">
                                            <input type="hidden" name="active" value="1">
                                            <button class="badge bg-danger">Inactive</button>
                                        @endif
                                    </form>
                                </td>
                                <td>{{ $permission->group->name }}</td>
                                <td>
                                    <a href="{{ route('permissions.edit', $permission->id) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $permissions->links() }}
        </div>
    </div>
@endsection
