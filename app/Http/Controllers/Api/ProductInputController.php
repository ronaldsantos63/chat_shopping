<?php

namespace ChatShopping\Http\Controllers\Api;

use ChatShopping\Http\Controllers\Controller;
use ChatShopping\Http\Requests\ProductInputRequest;
use ChatShopping\Http\Resources\ProductInputResource;
use ChatShopping\Models\Product;
use ChatShopping\Models\ProductInput;

class ProductInputController extends Controller
{
    public function index(Product $product)
    {
        return new ProductInputResource($product);
    }

    public function store(ProductInputRequest $request, Product $product)
    {
        $product->inputs()->create($request->all());
        $product->stock += $request->all()['amount'];
        $product->save();
        return new ProductInputResource($product);
    }
}
