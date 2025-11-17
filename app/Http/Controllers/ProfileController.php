<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function edit() {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request) {
        $user = User::find(Auth::id());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
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

        return "Profile berhasil diupdate";
    }
}
