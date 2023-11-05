<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
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

Route::group([
    'controller' => LoginController::class,
], function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store')->name('login.store');
    Route::post('/logout', 'destroy')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::inertia('/', 'Home');

    Route::group([
        'prefix' => '/users',
        'as' => 'users.',
        'controller' => UserController::class,
    ], function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::inertia('/create', 'Users/Create')->can('create', User::class);
        Route::get('/{user}/edit', 'edit')->middleware('can:edit,user');
        Route::put('/{user}/edit', 'update');
    });
});
