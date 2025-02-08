<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('CANDIDATE_API_URL');
    }

    // Show Login Page
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle Login Request
  public function login(Request $request)
{
	// dd($request->all());
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $response = Http::post("$this->apiUrl/token", [
        'email' => $request->email,
        'password' => $request->password,
    ]);
    if ($response->successful()) {
        $data = $response->json();
    // dd($data);

        session([
            'api_token' => $data['token_key'],
            'user_name' => $data['user']['first_name'] . ' ' . $data['user']['last_name'],
        ]);
        // dd(Session::get('api_token'),$data);
        return redirect()->route('authors.index')->with('success', 'Logged in successfully!');
    }

    return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
}

    // Logout User
    public function logout()
    {
        Session::forget('api_token');
        Session::forget('user_name');
        return redirect()->route('login');
    }
}
