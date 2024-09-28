<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmazonAuth extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'access_token',
        'refresh_token',
        'expires_in',
        'token_type'
    ];
    
    protected $primaryKey = 'user_store_id';

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
