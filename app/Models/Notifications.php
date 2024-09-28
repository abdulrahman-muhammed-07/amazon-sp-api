<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $fillable = [
        'asin',
        'sku',
        'EventTime',
        'CreatedDate',
        'SubscriptionId',
        'NotificationId',
        'error',
        'changes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public $incrementing = false;
}
