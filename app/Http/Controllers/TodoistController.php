<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TodoistController extends Controller
{
    public function authRedirect(Request $req) {
        echo json_encode([$req->input('code'), $req->input('state')]);


        $response = Http::post('https://todoist.com/oauth/access_token', [
            'client_id'     => env('TODOIST_CLIENT_ID'),
            'client_secret' => env('TODOIST_CLIENT_SECRET'),
            'redirect_uri'  => env('TODOIST_EXCHANGE_REDIRECT_URI'),
            'code'          => $req->input('code'),
        ]);

        dd($response);
    }
}
