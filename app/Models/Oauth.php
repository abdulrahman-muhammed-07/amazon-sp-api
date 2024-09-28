<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Oauth extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'access_token',
        'refresh_token',
        'expiry_date',
        'store_name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    protected $primaryKey = 'user_store_id';

    public $incrementing = false;
}
