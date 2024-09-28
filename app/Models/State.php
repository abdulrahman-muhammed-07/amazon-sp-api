<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'state',
        'expiry_date'
    ];

    public $timestamps = false;

    protected $primaryKey = 'user_store_id';
    
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
