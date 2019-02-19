<?php

namespace Emarketing;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = [
        "product_name", "product_description", "price", "producer_id", "photo"
    ];
}
