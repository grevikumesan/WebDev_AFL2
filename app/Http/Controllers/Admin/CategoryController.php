<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // 1. Menampilkan Daftar Kategori
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    // 2. Menampilkan Form Tambah Kategori
    public function create()
    {
        return view('admin.categories.create');
    }

    // 3. Proses Simpan Kategori
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories|max:255',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
                       ->with('success', 'Kategori berhasil ditambahkan!');
    }

    // 4. Menampilkan Form Edit Kategori
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // 5. Proses Update Kategori
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id . '|max:255',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
                       ->with('success', 'Kategori berhasil diperbarui!');
    }

    // 6. Proses Hapus Kategori
    public function destroy(Category $category)
    {
        // Cegah hapus kategori yang punya produk
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                           ->with('error', 'Tidak bisa hapus kategori yang masih ada produknya! Hapus produk terlebih dahulu.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
                       ->with('success', 'Kategori berhasil dihapus!');
    }
}
