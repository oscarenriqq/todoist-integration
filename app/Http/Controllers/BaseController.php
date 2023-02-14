<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function home() {
        return response()->json('FROM HOME');
    }

    public function testUser() {
        dd(Auth::user()->email);
    }

}
