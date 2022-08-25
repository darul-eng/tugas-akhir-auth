<?php

use App\Models\User;
use App\GraphQL\Queries\SDM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\HumanResourceController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/verify', [LoginController::class, 'verify']);
Route::post('/logout', [LoginController::class, 'logout']);
// Route::get('/tes', function () {
//     // dd(session()->get('restToken'));
//     // dd(Auth::user());
// });