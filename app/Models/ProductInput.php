<?php

namespace ChatShopping\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInput extends Model
{
    protected $fillable = ['amount'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
