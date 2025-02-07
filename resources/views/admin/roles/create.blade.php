@extends('components.layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Create Role</h3>
            <a href="{{ route('roles.index') }}" class="btn btn-info btn-sm float-right">Back</a>
        </div>

        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        id="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="permission" class="form-label">Permissions</label>
                    <div class="accordion" id="permissionsAccordion">
                        @foreach ($groups as $group)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $group->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $group->id }}" aria-expanded="false"
                                        aria-controls="collapse{{ $group->id }}">
                                        {{ $group->name }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $group->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $group->id }}" data-bs-parent="#permissionsAccordion">
                                    <div class="accordion-body">
                                        @foreach ($group->permissions as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input @error('permissions') is-invalid @enderror"
                                                    type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                    id="permission{{ $permission->id }}"
                                                    {{ is_array(old('permissions')) && in_array($permission->id, old('permissions')) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('permissions')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Create Role</button>
            </form>
        </div>
    </div>
@endsection
