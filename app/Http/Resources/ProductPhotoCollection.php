<?php

namespace ChatShopping\Http\Resources;

use ChatShopping\Models\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductPhotoCollection extends ResourceCollection
{
    /**
     * @var Product
     */
    private $product;

    /**
     * ProductPhotoCollection constructor.
     * @param mixed $resource
     * @param Product $product
     */
    public function __construct($resource, Product $product)
    {
        parent::__construct($resource);
        $this->product = $product;
    }


    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product' => new ProductResource($this->product),
            'photos' => $this->collection->map(function ($photo){
                return new ProductPhotoResource($photo, true);
            })
        ];
    }
}
