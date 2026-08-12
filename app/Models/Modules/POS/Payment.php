<?php

namespace App\Models\Modules\POS;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'pos_payments';

    protected $fillable = [
        'sale_id',
        'amount',
        'method',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
