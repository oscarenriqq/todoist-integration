<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoistController extends Controller
{
    public function getAccess(Request $req) {
        echo $req;
    }
}