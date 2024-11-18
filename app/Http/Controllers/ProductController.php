<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
      // Menampilkan produk termurah
      public function cheapest(): JsonResponse
      {
          $product = Product::orderBy('price', 'asc')->first();
  
          if (!$product) {
              return response()->json(['message' => 'No products found'], 404);
          }
  
          return response()->json(['product' => $product], 200);
      }
  
      // Menampilkan produk termahal
      public function mostExpensive(): JsonResponse
      {
          $product = Product::orderBy('price', 'desc')->first();
  
          if (!$product) {
              return response()->json(['message' => 'No products found'], 404);
          }
  
          return response()->json(['product' => $product], 200);
      }
      public function bulkUpdatePrices(Request $request)
      {
          Log::info('Request received', ['request' => $request->all()]);
      
          $validatedData = $request->validate([
              'products' => 'required|array',
              'products.*.id' => 'required|integer|exists:products,id',
              'products.*.price' => 'required|numeric|min:0',
          ]);
      
          Log::info('Validated Data:', $validatedData);
      
          $updatedProducts = [];
          foreach ($validatedData['products'] as $productData) {
              $product = Product::find($productData['id']);
              if ($product) {
                  $product->price = $productData['price'];
                  $product->save();
                  $updatedProducts[] = $product->toArray();
                  Log::info('Updated Product:', $product->toArray());
              } else {
                  Log::warning('Product not found with ID: ' . $productData['id']);
              }
          }
      
          Log::info('Prices updated successfully, returning response.');
      
          return response()->json([
              'message' => 'Harga produk berhasil diperbarui.',
              'updated_products' => $updatedProducts
          ], 200);
      }
}

