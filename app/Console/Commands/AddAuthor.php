<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;

class AddAuthor extends Command
{
   protected $signature = 'author:add {name}';
    protected $description = 'Add a new author to the API';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return int
     */

public function handle()
{
    $name = $this->argument('name');

    // Step 1: Login and get token
    $loginResponse = Http::post(env('CANDIDATE_API_URL') . '/token', [
        'email' => env('CANDIDATE_API_EMAIL'), // Get email from .env
        'password' => env('CANDIDATE_API_PASSWORD'), // Get password from .env
    ]);

    // Step 2: Check if login was successful and extract the token
    if ($loginResponse->successful()) {
        $token = $loginResponse->json()['access_token']; // Extract token from response

        // Step 3: Add the author using the token
        $response = Http::withToken($token)->post(env('CANDIDATE_API_URL') . "/authors", [
            'name' => $name,
        ]);

        // Step 4: Check the response of author creation
        if ($response->successful()) {
            $this->info("Author '$name' added successfully!");
        } else {
            $this->error("Failed to add author.");
        }
    } else {
        // Login failed
        $this->error("Failed to login. Please check your credentials.");
    }
}

}
