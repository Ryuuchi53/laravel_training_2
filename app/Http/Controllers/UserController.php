<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama diperlukan',
            'name.max' => 'Nama tidak boleh melebihi :max aksara',
            'email.required' => 'Email diperlukan',
            'email.email' => 'Email tidak sah',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Kata laluan diperlukan',
            'password.min' => 'Kata laluan mesti sekurang-kurangnya :min aksara',
            'password.confirmed' => 'Kata laluan dan pengesahan tidak sepadan',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->route('users.create')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Sila semak semula');
        }

        $validated = $validator->validated();

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
    public function update(Request $request, $id)
    {
        $messages = [
            'name.required' => 'Nama diperlukan',
            'name.max' => 'Nama tidak boleh melebihi :max aksara',
            'email.required' => 'Email diperlukan',
            'email.email' => 'Email tidak sah',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ], $messages);

        $user = user::findOrFail($id);

        if ($validator->fails()) {
            return redirect()->route('users.edit', $user->id)
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Sila semak semula');
        }

        $validated = $validator->validated();

        $name = $validated['name'];
        $email = $validated['email'];

        $user->name = $name;
        $user->email = $email;
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
