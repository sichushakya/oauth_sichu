<?php

use App\Http\Controllers\GithubController;
use App\Http\Controllers\JsonController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('auth/github', [GithubController::class, 'toGitHub'] )->name('auth.github');

Route::get('auth/callback', [GithubController::class, 'callback'] )->name('auth.callback');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('auth:web')->group(function () {
    Route::get('form', [JsonController::class, 'index'])->name('form');
    Route::post('upload/json', [JsonController::class, 'uploadJson'])->name('upload.json');
    Route::get('export/json', [JsonController::class, 'exportJson'])->name('export.json');
});


