<?php

namespace App\Models\Modules\POS;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'pos_products';

    protected $fillable = [
        'sku',
        'name',
        'price',
        'stock',
    ];
}
