@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Groups List</h3>
        </div>

        <div class="card-body">
            @if (session('update'))
                <div class="alert alert-info alert-dismissible fade show" role="alert"> {{ session('update') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Permissions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                            <tr>
                                <th>{{ $group->id }}</th>
                                <td>{{ $group->name }}</td>
                                <td>
                                    <form action="{{ route('groups.status', $group->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if ($group->status == 1)
                                            <input type="hidden" name="id" value="{{ $group->id }}">
                                            <input type="hidden" name="active" value="0">
                                            <button class="badge bg-success">Active</button>
                                        @else
                                            <input type="hidden" name="id" value="{{ $group->id }}">
                                            <input type="hidden" name="active" value="1">
                                            <button class="badge bg-danger">Inactive</button>
                                        @endif
                                    </form>
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#permissionsModal{{ $group->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="permissionsModal{{ $group->id }}" tabindex="-1"
                                aria-labelledby="permissionsModalLabel{{ $group->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="permissionsModalLabel{{ $group->id }}">
                                                Permissions for Group: {{ $group->name }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="accordion" id="permissionsAccordion{{ $group->id }}">
                                                <ul class="list-group">
                                                    @foreach (\App\Models\Permission::where('group_id', $group->id)->get() as $permission)
                                                        <div class="form-check">
                                                            <li class="list-group-item">
                                                                {{ $permission->name }}
                                                            </li>
                                                        </div>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
