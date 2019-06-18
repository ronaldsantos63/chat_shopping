<?php

namespace ChatShopping\Http\Controllers\Api;

use ChatShopping\Http\Controllers\Controller;
use ChatShopping\Http\Requests\ProductInputRequest;
use ChatShopping\Http\Resources\ProductInputResource;
use ChatShopping\Models\Product;
use ChatShopping\Models\ProductInput;

class ProductInputController extends Controller
{
    public function index()
    {
        // Usar o with para evitar multiplas consultas no banco de dados, (consultas nos relacionamentos)
        $inputs = ProductInput::with('product')->paginate();
        return ProductInputResource::collection($inputs);
    }

    public function store(ProductInputRequest $request)
    {
        $input = ProductInput::create($request->all());
        return new ProductInputResource($input);
    }

    public function show(ProductInput $input){
        return new ProductInputResource($input);
    }
}
