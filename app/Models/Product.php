<?php

namespace ChatShopping\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Sluggable, SoftDeletes;

    protected $dates = ['deleted_at'];
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

    public function photos(){
        return $this->hasMany(ProductPhoto::class);
    }
}
