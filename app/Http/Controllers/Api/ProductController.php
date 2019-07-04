<?php

namespace ChatShopping\Http\Controllers\Api;

use ChatShopping\Http\Controllers\Controller;
use ChatShopping\Http\Requests\ProductRequest;
use ChatShopping\Http\Resources\ProductResource;
use ChatShopping\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        return ProductResource::collection(Product::paginate(25));
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());
        $product->refresh();
        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->fill($request->all());
        $product->save();
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response([], 204);
    }

    public function restore(Product $product)
    {
        $product->restore();
        return response()->json([], 204);
    }
}
