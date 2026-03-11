<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->input('name');

        $users = User::where(function ($query) {
            $query->when(request()->filled('name'), function ($query) {
                $query->where('name', 'like', '%' . request()->name . '%');
            });
        })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna berjaya ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = user::findOrFail($id);
        $user->fill($request->validated());
        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna berjaya dikemaskini');
    }

    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 0;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna berjaya dinyahaktif');
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 1;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna berjaya diaktifkan');
    }
}
