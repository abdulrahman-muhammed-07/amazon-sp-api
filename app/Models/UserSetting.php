<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        "settings",
        'mapping_settings',
        'mapping_settings_defaults',
        'mapping_settings_properties',
        "last_updates",
        "user_store_id",
        "master_switch_sync_all_plugin",
        "sync_Application_amazon_price",
        "sync_Application_amazon_qty",
        "sync_amazon_Application_price",
        "LWA_CLIENT_ID",
        "LWA_CLIENT_SECRET",
        "AWS_ACCESS_KEY",
        "AWS_SECRET_ACCESS_KEY",
        "AWS_DEFAULT_REGION",
        'SELLER_ID',
        "MARKET_PLACE_ID",
        "AMAZON_APP_ID",
        "ASIN",
        "REPORT_TYPE",
        "DEVELOPER_ID",
        "AWS_BUCKET",
        "AWS_USE_PATH_STYLE_ENDPOINT",
        "AWS_ACCESS_KEY_ID_IMAGE_UPLOAD",
        "LWA_ACCESS_TOKEN",
        "LWA_REFRESH_TOKEN",
        "ROLE_ARN",
        'AWS_ROLE_ARN'
    ];

    protected $primaryKey = 'user_store_id';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $model->mapping_settings =
                json_encode(
                    [
                        'item_name' => 'product_name',
                        'variant_id' => 'product_id',
                        'variant_price' => 'product_price',
                        'variant_discount_price' => 'product_discount_price',
                        'brand' => 'product_name',
                        'bullet_point' => 'product_description',
                        'color' => 'RED_static',
                        'model_name' => 'product_name',
                        'model_number' => 'product_name',
                        'list_price' => 'variant_price',
                        'style' => 'product_name',
                        'item_type_keyword' => 'PRODUCT_static',
                        'country_of_origin' => "US_static",
                        'supplier_declared_dg_hz_regulation' => 'not_applicable_static',
                        'merchant_suggested_asin' => '21s6d5f1s1_static',
                        "fulfillment_availability" => "product_total_qty_check_Application_compare_quantity_boolean",
                        'condition_type' => 'new_new_static'
                    ]
                );

            $model->mapping_settings_defaults =
                json_encode(
                    [
                        'item_name' => 'product_name',
                        'variant_id' => 'product_id',
                        'variant_price' => 'product_price',
                        'variant_discount_price' => 'product_discount_price',
                        'brand' => 'product_name',
                        'bullet_point' => 'product_description',
                        'color' => 'RED_static',
                        'model_name' => 'product_name',
                        'model_number' => 'product_name',
                        'list_price' => 'variant_price',
                        'style' => 'product_name',
                        'item_type_keyword' => 'PRODUCT_static',
                        'country_of_origin' => "US_static",
                        'supplier_declared_dg_hz_regulation' => 'not_applicable_static',
                        'merchant_suggested_asin' => '21s6d5f1s1_static',
                        "fulfillment_availability" => "product_total_qty_check_Application_compare_quantity_boolean",
                        'condition_type' => 'new_new_static'
                    ]
                );

            $model->mapping_settings_properties =
                json_encode(
                    [
                        "Application_data" =>
                        [
                            "product_description",
                            "product_name",
                            "variant_id",
                            'product_model',
                            'product_brand',
                            'variant_price',
                            'product_type'
                        ],
                        "amazon_data" => [
                            'custom_label_0',
                            'custom_label_1',
                            'custom_label_2',
                            'custom_label_3',
                            'custom_label_4',
                            'ads_redirect',
                            'ads_grouping',
                            'ads_labels',
                            'adult',
                            'age_group',
                            'availability',
                            'availability_date',
                            'additional_image_link',
                            'additional_size_type',
                            'condition',
                            'display_ads_title',
                            'display_ads_value',
                            'energy_efficiency_class',
                            'excluded_destination',
                            'expiration_date',
                            'external_seller_id',
                            'feed_label',
                            'gender',
                            'identifier_exists',
                            'is_bundle',
                            'kind',
                            'lifestyle_image_link',
                            'material',
                            'multipack',
                            'pickup_method',
                            'size_type',
                            'sizes'
                        ]
                    ]
                );
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSettingsAttribute($value)
    {
        if ($value != null) {
            return json_decode($value);
        } else {
            return null;
        }
    }
}
