<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(5);
        return "List User";
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return "Create User";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,customer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Urus Password (karena kita di Laravel 12)
        $validatedData['password'] = $validatedData['password']; // Biar di-hash sama Model

        // Urus Image Upload
        if ($request->hasFile('image')) {
            // Simpen filenya ke 'storage/app/public/user-images'
            $path = $request->file('image')->store('user-images', 'public');
            $validatedData['image'] = $path;
        }

        User::create($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return "Nampilin detail user: " . $user->name;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
         return "Nampilin form edit user: " . $user->name;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Mirip kayak store(), tapi validasi email-nya beda
        // dan logic password-nya beda (kalo kosong, jangan di-update)
        // Hati-hati juga sama logic hapus gambar lama kalo ada gambar baru
        // --- 1. Validasi Input ---
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',

            // Rule email: Wajib, email, unik KECUALI untuk ID user ini sendiri
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('users')->ignore($user->id),
            ],

            'role' => 'required|in:admin,customer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // --- 2. Logic Upload Gambar (kalo ada gambar baru) ---
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
            // Kalo password baru diisi, validasi dulu
            $request->validate([
                'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)],
            ]);

            // Model 'User' akan otomatis nge-hash ini
            $validatedData['password'] = $request->password;
        }

        // --- 4. Update data user ---
        // Panggil 'update' di VARIABEL $user, BUKAN di Model User::
        $user->update($validatedData);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil di-update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Hapus gambar lamanya dulu dari storage
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        // Hapus data user-nya
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}
