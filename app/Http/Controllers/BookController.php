<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class BookController extends Controller
{
    private $apiUrl;
    private $apiToken;

    public function __construct()
    {
        $this->apiUrl = env('CANDIDATE_API_URL');
        $this->apiToken = Session::get('api_token');
    }

    // Delete a book
    public function destroy($id)
    {
        $response = Http::withToken(Session::get('api_token'))->delete("$this->apiUrl/books/$id");

        if ($response->successful()) {
            return back()->with('success', 'Book deleted successfully.');
        }

        return back()->withErrors(['error' => 'Failed to delete book.']);
    }

    // Show form to add a book
    public function create()
    {
        $response = Http::withToken(Session::get('api_token'))->get("$this->apiUrl/authors");

        if ($response->successful()) {
            $authors = $response->json();
            // dd($authors);
            return view('books.create', compact('authors'));
        }

        return back()->withErrors(['error' => 'Failed to fetch authors.']);
    }

    // Store a new book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author_id' => 'required',
        ]);
        
        $response = Http::withToken(Session::get('api_token'))->post("$this->apiUrl/books", [
            'title' => $request->title,
            'author_id' => $request->author_id,
        ]);

        if ($response->successful()) {
            return redirect()->route('authors.index')->with('success', 'Book added successfully!');
        }

        return back()->withErrors(['error' => 'Failed to add book.']);
    }
}
