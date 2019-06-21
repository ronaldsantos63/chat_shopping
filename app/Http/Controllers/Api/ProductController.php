<?php

namespace ChatShopping\Http\Controllers\Api;

use ChatShopping\Http\Controllers\Controller;
use ChatShopping\Http\Requests\ProductRequest;
use ChatShopping\Http\Resources\ProductResource;
use ChatShopping\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        $query = $this->onlyTrashedIfRequested($request, $query);
        return ProductResource::collection($query->paginate(25));
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

    private function onlyTrashedIfRequested(Request $request, Builder $query)
    {
        if ($request->get('trashed') == 1){
            $query = $query->onlyTrashed();
        }
        return $query;
    }
}
