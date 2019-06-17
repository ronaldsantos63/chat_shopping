<?php

namespace ChatShopping\Http\Controllers\Api;

use ChatShopping\Http\Controllers\Controller;
use ChatShopping\Http\Requests\CategoryRequest;
use ChatShopping\Http\Resources\CategoryResource;
use ChatShopping\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());
        $category->refresh();
        return CategoryResource::make($category);
    }

    public function show(Category $category)
    {
        return CategoryResource::make($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->fill($request->all());
        $category->save();

        return CategoryResource::make($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response([], 204);
    }
}
