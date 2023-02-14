<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Models\TodoistAccess;

class TodoistController extends Controller
{
    public function getToken() {
        $client_id = env('TODOIST_CLIENT_ID');
        $scope = env('TODOIST_SCOPE');
        $secret_string = env('TODOIST_SECRET_STRING');
        return response()->json(['url' => "https://todoist.com/oauth/authorize?client_id={$client_id}&scope={$scope}&state={$secret_string}"]);
    }

    public function authRedirect(Request $req) {

        try {

            $todoistAccessModel = new TodoistAccess();

            $req = Http::post('https://todoist.com/oauth/access_token', [
                'client_id'     => env('TODOIST_CLIENT_ID'),
                'client_secret' => env('TODOIST_CLIENT_SECRET'),
                'redirect_uri'  => env('TODOIST_REDIRECT_URI'),
                'code'          => $req->input('code'),
            ]);

            $response = json_decode([$req->body()], true);

            $access_token = $response['access_token'];

            $todoistAccessModel->email = Auth::user()->email;
            $todoistAccessModel->access_token = $access_token;

            $todoistAccessModel->save();

            return response()->json(['message' => 'ok'], 200);

        }
        catch(Exception $e) {
            return response()->json(['message' => 'error'], 500);
        }
    }
}
