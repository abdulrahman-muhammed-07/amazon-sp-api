<?php

namespace App\Helpers\Amazon;

use Illuminate\Support\Str;

class AmazonSkuBuilderHelper
{

    /**
     * Build Amazon Request Sku.
     *
     * @param $product
     * @param $variant
     * @return integer
     */
    public static function buildAmazonSku($product, $variant)
    {
        $sku = Str::random(10);

        if (!empty($variant->getVariantSku())) {
            $sku = $variant->getVariantSku();
        } elseif (!empty($product->getProductSku())) {
            $sku = $product->getProductSku();
        }

        return $sku;
    }
}
