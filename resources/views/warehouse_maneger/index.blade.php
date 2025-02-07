@extends('components.layouts.app')

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
                                    <form action="{{ route('revenues.show', $revenue->id) }}" method="GET">
                                        <button type="submit" class="btn btn-info"><i class="fas fa-eye"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $revenues->links() }}
            </div>
        </div>
    </div>
@endsection
