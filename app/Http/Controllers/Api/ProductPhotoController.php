<?php

namespace ChatShopping\Http\Controllers\Api;

use ChatShopping\Http\Controllers\Controller;
use ChatShopping\Http\Requests\ProductPhotoRequest;
use ChatShopping\Http\Requests\ProductPhotoUpdateRequest;
use ChatShopping\Http\Resources\ProductPhotoCollection;
use ChatShopping\Http\Resources\ProductPhotoResource;
use ChatShopping\Models\Product;
use ChatShopping\Models\ProductPhoto;
use Illuminate\Http\Request;

class ProductPhotoController extends Controller
{
    public function index(Product $product)
    {
        return new ProductPhotoCollection($product->photos, $product);
    }

    public function store(ProductPhotoRequest $request, Product $product)
    {
        $photos = ProductPhoto::createWithPhotosFiles($product->id, $request->photos);
        return response()->json(new ProductPhotoCollection($photos, $product), 201);
    }

    public function show(Product $product, ProductPhoto $photo)
    {
        if ($photo->product_id != $product->id)
        {
            abort(404);
        }
        return new ProductPhotoResource($photo);
    }

    public function update(ProductPhotoUpdateRequest $request, Product $product, ProductPhoto $photo)
    {
        $photoUpdated = ProductPhoto::updateWithPhotoFile($product->id, $photo, $request->photo);
        return new ProductPhotoResource($photoUpdated);
    }

    public function destroy(Product $product, ProductPhoto $photo)
    {
        ProductPhoto::deleteWithPhotosFiles($product->id, $photo);
        return response()->json([], 204);
    }
}
