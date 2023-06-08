<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'string|required|max:255',
            'price' => 'integer|required|max:999999',
            'category_id' => 'required|exists:categories,id',
        ]);
        $product = Product::create($data);

        return new ProductResource($product);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'string|required|max:255',
            'price' => 'integer|required|max:999999',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update($data);

        return new ProductResource($product);
    }
    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource(Product::find($product->id));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(null, 204);
    }
}
