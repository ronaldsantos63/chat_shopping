<?php

namespace ChatShopping\Http\Controllers\Api;

use ChatShopping\Http\Controllers\Controller;
use ChatShopping\Http\Requests\ProductCategoryRequest;
use ChatShopping\Http\Resources\ProductCategoryResource;
use ChatShopping\Models\Category;
use ChatShopping\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductCategoryController extends Controller
{
    public function index(Product $product)
    {
        return new ProductCategoryResource($product);
    }

    public function store(ProductCategoryRequest $request, Product $product)
    {
        $changed = $product->categories()->sync($request->categories);
        $categoriesAttachedId = $changed['attached'];
        /** @var Collection $categories */
        $categories = Category::whereIn('id', $categoriesAttachedId)->get();
        return $categories->count() ?
            response()
                ->json(new ProductCategoryResource($product), 201) :
            $categories;
    }

    public function destroy(Product $product, Category $category)
    {
        $product->categories()->detach($category->id);
        return response()->json([], 204);
    }
}
