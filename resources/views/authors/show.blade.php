@extends('layouts.app')

@section('title', 'Author Details')

@section('content')
    <div class="card shadow-sm p-4">
        <h3>Author: {{ $author['first_name']}}{{ $author['last_name'] }}</h3>
        
        <!-- Add Book Button -->
        <a href="{{ route('books.create', ['author_id' => $author['id']]) }}" class="btn btn-success mb-3">Add Book</a>

        <h4>Books:</h4>
        @if (!empty($author['books']))
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($author['books'] as $book)
                        <tr>
                            <td>{{ $book['id'] }}</td>
                            <td>{{ $book['title'] }}</td>
                            <td>
                                <form action="{{ route('books.destroy', $book['id']) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No books available.</p>
        @endif

        <a href="{{ route('authors.index') }}" class="btn btn-secondary">Back to Authors</a>
    </div>
@endsection
