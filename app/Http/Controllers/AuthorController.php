<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthorController extends Controller
{
    private $apiUrl;
    private $apiToken;

    public function __construct()
    {
        $this->apiUrl = env('CANDIDATE_API_URL');
        $this->apiToken = Session::get('api_token');
    }

    // Fetch and display authors
    public function index()
    {

        $response = Http::withToken(Session::get('api_token'))->get("$this->apiUrl/authors");

        // dd($response);
        if ($response->successful()) {
            $authors = $response->json();
            // dd($authors);
            return view('authors.index', compact('authors'));
        }

        return back()->withErrors(['error' => 'Failed to fetch authors.']);
    }

    // Show a single author with their books
  public function show($id)
    {
        $response = Http::withToken(Session::get('api_token'))->get("$this->apiUrl/authors/$id");

        if ($response->successful()) {
            $author = $response->json();
            // dd($author);
            return view('authors.show', compact('author'));
        }

        return back()->withErrors(['error' => 'Author not found.']);
    }

    // Delete author only if they have no books
    public function destroy($id)
    {
        $authorResponse = Http::withToken(Session::get('api_token'))->get("$this->apiUrl/authors/$id");

        if (!$authorResponse->successful()) {
            return back()->withErrors(['error' => 'Author not found.']);
        }

        $author = $authorResponse->json();
        if (!empty($author['books'])) {
            return back()->withErrors(['error' => 'Cannot delete author with books.']);
        }

        $deleteResponse = Http::withToken(Session::get('api_token'))->delete("$this->apiUrl/authors/$id");

        if ($deleteResponse->successful()) {
            return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
        }

        return back()->withErrors(['error' => 'Failed to delete author.']);
    }
}
