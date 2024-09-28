<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AmazonFeeds extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'feed_document_id',
        'feed_upload_url',
        'uploaded_to_status',
        'x-amzn-RequestId',
        'x-amz-apigw-id',
        'feed_content',
        'input_feed_document_id',
        'submitted_feed_id',
        'result_feed_document_id',
        'processing_end_time',
        'processing_status'
    ];


    public $incrementing = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeFeedDocumentId(Builder $builder, $feedDocumentId)
    {
        $builder->where('feed_document_id', $feedDocumentId);
    }

    public function scopeFeedUploadedStatus(Builder $builder)
    {
        $builder->where('uploaded_to_status', '=', 0);
    }

    public function scopeExpired(Builder $builder)
    {
        $builder->where('expires_in', '>', time());
    }
}
