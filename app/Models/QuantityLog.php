<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuantityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'product_uuid',
        'variant_uuid',
        'old_quantity',
        'new_quantity',
        'change_from',
        'old_price',
        'new_price',
        'type',
        'user_store_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
