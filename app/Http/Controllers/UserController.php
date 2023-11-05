<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
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
    }

    public function store()
    {
        $attr = request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:' . User::class . ',email'],
            'password' => ['required'],
        ]);
        User::create($attr);

        return redirect('/users');
    }

    public function edit(User $user)
    {
        return inertia('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    public function update(User $user)
    {
        $attr = request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user->update($attr);

        return redirect('/users');
    }
}
