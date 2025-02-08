@extends('layouts.app')

@section('title', 'Add Book')

@section('content')
    <div class="card shadow-sm p-4">
        <h3>Add a New Book</h3>

        <form action="{{ route('books.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Author:</label>
                <select name="author_id" class="form-select" required>
                    @foreach($authors['items'] as $author)
                        <option value="{{ $author['id'] }}" 
                            {{ isset($selectedAuthorId) && $selectedAuthorId == $author['id'] ? 'selected' : '' }}>
                            {{ $author['first_name']}} {{ $author['last_name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Book</button>
            <a href="{{ route('authors.index') }}" class="btn btn-secondary">Back to Authors</a>
        </form>
    </div>
@endsection
