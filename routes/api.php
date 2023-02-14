<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\TodoistController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function() {
    Route::get('/home', [BaseController::class, 'home']);
    Route::get('/test', [BaseController::class, 'testUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/todoist/auth', [TodoistController::class, 'getToken']);

});

Route::get('/todoist/redirect', [TodoistController::class, 'authRedirect']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


