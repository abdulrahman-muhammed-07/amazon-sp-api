<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'product_uuid',
        'variant_uuid',
        'quantity',
        'issues',
        'sent',
        'seller_sku',
        'amazon_asin_id',
        'parentage_level',
        'parent_sku',
        'action_from',
        'lex_hash',
        'amazon_hash',
        'color',
        'variation_theme',
        'bullet_points_array',
        'offers_array',
        'gift_options',
        'department',
        'product_description',
        'brand',
        'item_name',
        'externally_assigned_product_identifier',
        'externally_assigned_product_identifier_type',
        'list_price',
        'product_tax_code',
        'condition_type',
        'size',
        'main_product_image_locator',
        'child_relationship_type',
        'status',
        'condition_type',
        'product_type',
        'status_report',
        'asin'
    ];

    public $incrementing = false;

    public function setSentAttribute($value)
    {
        $this->attributes['sent'] = ($value === 'true' || $value === true ? true : false);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAmazonId(Builder $builder, $id)
    {
        $builder->where('seller_sku', $id);
    }

    public function scopeSent(Builder $builder, $sent)
    {
        $builder->where('sent', $sent);
    }

    public function scopeVariantId(Builder $builder, $id)
    {
        $builder->where('variant_uuid', $id);
    }

    public function scopeProductId(Builder $builder, $id)
    {
        $builder->where('product_uuid', $id);
    }
}
