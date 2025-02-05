@extends('layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Revenues List</h3>
            <a href="{{ route('revenues.create') }}" class="btn btn-primary btn-sm float-right">Create revenue</a>
        </div>

        <div class="card-body">
            @if (session('create'))
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    {{ session('create') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Company name</th>
                            <th>Date</th>
                            <th>Text</th>
                            <th>Materials</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($revenues as $revenue)
                            <tr>
                                <th>{{ $revenue->id }}</th>
                                <td>{{ $revenue->company }}</td>
                                <td>{{ $revenue->date }}</td>
                                <td>{{ $revenue->text }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#materials{{ $revenue->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="materials{{ $revenue->id }}" tabindex="-1"
                                aria-labelledby="materialsLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="materialsLabel">Materials for Revenue
                                                #{{ $revenue->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                @foreach ($revenue->entry_materials as $entryMaterial)
                                                    <li>{{ $entryMaterial->material->name }} -
                                                        {{ $entryMaterial->quantity }} {{ $entryMaterial->unit }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                {{ $revenues->links() }}
            </div>
        </div>
    </div>
@endsection
