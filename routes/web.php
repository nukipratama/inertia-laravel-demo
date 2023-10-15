<?php

use App\Http\Controllers\Auth\LoginController;
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

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::inertia('/', 'Home');

    Route::inertia('/settings', 'Settings');

    Route::group(['prefix' => '/users'], function () {
        Route::get('/', function () {
            $search = request()->get('search');

            return inertia('Users/Index', [
                'users' => User::query()
                    ->when($search, fn ($q) => $q->where('name', 'LIKE', "%{$search}%"))
                    ->paginate(10)
                    ->withQueryString()
                    ->through(fn ($user) => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'can' => [
                            'edit' => auth()->user()->can('edit', $user),
                        ]
                    ]),
                'filters' => request()->only(['search']),
                'can' => [
                    'create_users' => auth()->user()->can('create', User::class),
                ],
            ]);
        });

        Route::post('/', function () {
            $attr = request()->validate([
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:' . User::class . ',email'],
                'password' => ['required'],
            ]);
            User::create($attr);

            return redirect('/users');
        });

        Route::put('/{user}/edit', function (User $user) {
            $attr = request()->validate([
                'name' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $user->update($attr);

            return redirect('/users');
        });

        Route::inertia('/create', 'Users/Create')->can('create', User::class);
        Route::get('/{user}/edit', function (User $user) {
            return inertia('Users/Edit', [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
        })->middleware('can:edit,user');
    });

    Route::post('/logout', [LoginController::class, 'destroy']);
});
