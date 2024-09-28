<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AmazonReports extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'report_type',
        'report_id',
        'report_status',
        'report_document_id',
        'report_url'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public $incrementing = false;
}
