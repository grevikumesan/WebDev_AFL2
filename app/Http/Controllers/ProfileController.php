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
    /**
     * Paksa user harus login dulu baru bisa akses controller ini.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Nampilin halaman form edit profile.
     */
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Update data profile di database.
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        // --- 1. Validasi Input ---
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

        // --- 2. Logic Upload Gambar (kalo ada) ---
        if ($request->hasFile('image')) {
            // Hapus gambar lama (kalo ada)
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            // Simpen gambar baru
            $path = $request->file('image')->store('user-images', 'public');
            $validatedData['image'] = $path;
        }

        // --- 3. Logic Ganti Password (kalo diisi) ---
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'confirmed', Password::min(8)],
            ]);

            $validatedData['password'] = $request->password;
        }

        // --- 4. Update data user ---
        $user->update($validatedData);

        // return redirect()->route('profile.edit')->with('success', 'Profile berhasil di-update!');
        return "Profile berhasil di-update!";
    }
}
