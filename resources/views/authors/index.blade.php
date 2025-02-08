@extends('layouts.app')

@section('title', 'Authors List')

@section('content')
    <div class="card shadow-sm p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Authors</h3>
            <a href="{{ route('books.create') }}" class="btn btn-primary">Add Book</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($authors['items'] as $author)
                    <tr>
                        <td>{{ $author['id'] }}</td>
                        <td>{{ $author['first_name']}} {{ $author['last_name'] }}</td>
                        <td>
                            <a href="{{ route('authors.show', $author['id']) }}" class="btn btn-info btn-sm">View</a>
                            <form action="{{ route('authors.destroy', $author['id']) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
