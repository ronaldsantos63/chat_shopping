<?php

namespace ChatShopping\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Sluggable;
    protected $fillable = ['name', 'description', 'price', 'active'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function inputs() {
        return $this->hasMany(ProductInput::class);
    }
}
