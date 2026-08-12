<?php

namespace App\Models\Modules\POS;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'pos_sales';

    protected $fillable = [
        'business_id',
        'user_id',
        'total',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }
}
