<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }
    public function create() {
        return view('users.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role'  => 'required|in:admin,kasir',
        ]);
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
        ]);
        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }
    public function edit(User $user) {
        return view('users.edit', compact('user'));
    }
    public function update(Request $request, User $user) {
        $request->validate([
            'name' => 'required|string|max:100',
            'role' => 'required|in:admin,kasir',
        ]);
        $user->update($request->only('name', 'role'));
        return redirect()->route('users.index')
            ->with('success', 'User berhasil diupdate!');
    }
    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus!');
   }
}
