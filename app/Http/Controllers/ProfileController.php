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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user(); // Gunakan Auth::user() agar lebih aman & pasti user yg login

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi gambar
            'delete_image' => 'nullable|boolean', // Validasi input hidden hapus
        ]);

        // 1. LOGIKA HAPUS GAMBAR (DELETE)
        // Jika user klik tombol "Hapus Foto" (input delete_image = 1)
        if ($request->boolean('delete_image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image); // Hapus file fisik
            }
            $validatedData['image'] = null; // Set kolom di DB jadi null
        }

        // 2. LOGIKA UPLOAD GAMBAR BARU (CREATE / UPDATE)
        if ($request->hasFile('image')) {
            // Hapus gambar lama dulu jika ada (biar ga numpuk sampah file)
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            // Upload gambar baru
            $path = $request->file('image')->store('user-images', 'public');
            $validatedData['image'] = $path;
        }

        // 3. LOGIKA PASSWORD (UPDATE)
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'confirmed', Password::min(8)],
            ]);
            $validatedData['password'] = bcrypt($request->password); // Manual hash biar aman
        } else {
            // Hapus key password dari array agar tidak ter-update jadi null/kosong
            unset($validatedData['password']);
        }

        // Hapus key delete_image karena tidak ada di kolom tabel users
        unset($validatedData['delete_image']);

        $user->update($validatedData);

        return redirect()->route('profile.edit') // Redirect balik ke halaman edit aja
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
