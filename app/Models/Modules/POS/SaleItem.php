<?php

namespace App\Models\Modules\POS;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $table = 'pos_sale_items';

    protected $fillable = [
        'sale_id',
        'product_id',
        'qty',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
