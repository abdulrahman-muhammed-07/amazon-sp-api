<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedJobsLaravel extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $table = 'failed_jobs_laravel';
    
    protected $fillable = [
        'job_name',
        'time',
        'status',
        'user_store_id',
        'fail_reason',
    ];
}
