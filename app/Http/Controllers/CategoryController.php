<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'description' => 'nullable|string',
        ]);

        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    public function show($id)
    {
        $category = Category::find($id);
        return $category ? response()->json($category) : response()->json(['message' => 'Category notfound'], 404);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if ($category) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $category->update($validated);
            return response()->json($category);
        }
        return response()->json(['message' => 'Category not found'], 404);
    }

    public function destroy($id)
    {

        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully']);
        }
        return response()->json(['message' => 'Category not found'], 404);
    }
    public function getProductsByCategory($id)
{
    // Cek apakah kategori dengan ID yang diberikan ada di database
    $category = Category::find($id);
    if (!$category) {
        return response()->json(['error' => 'Kategori tidak ditemukan.'], 404);
    }

    // Ambil semua produk yang terkait dengan kategori ini
    $products = $category->products; // Pastikan relasi sudah benar di model Category

    // Kembalikan hasil dalam bentuk array JSON
    return response()->json($products,200);
}
}
