<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessSetting extends Model
{
    protected $table = 'business_settings';

    protected $fillable = ['business_id', 'key_name', 'value'];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
