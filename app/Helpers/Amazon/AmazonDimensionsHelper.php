<?php

namespace App\Helpers\Amazon;

class AmazonDimensionsHelper
{
    public static function buildDimensionsObject($variant, $type, $dimensionType): ?array
    {
        return [
            "unit" => $dimensionType,
            "value" => $variant['variant' . ucfirst($type)]
        ];
    }
}
