<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index() {
$users = User::with('orders')->paginate(5);
        return view('admin.users.index', compact('users'));
    }

    public function create() {
        return view('admin.users.create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => ['required', Password::min(8)],
            'role' => 'required|in:admin,customer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $validatedData['password'] = $request->password;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('user-images', 'public');
            $validatedData['image'] = $path;
        }

        User::create($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat!');
    }

    public function show(User $user) {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user) {
         return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',

            // Rule email: Wajib, email, unik KECUALI untuk ID user ini sendiri
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],

            'role' => 'required|in:admin,customer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $path = $request->file('image')->store('user-images', 'public');
            $validatedData['image'] = $path;
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'confirmed', Password::min(8)],
            ]);

            $validatedData['password'] = $request->password;
        }

        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
