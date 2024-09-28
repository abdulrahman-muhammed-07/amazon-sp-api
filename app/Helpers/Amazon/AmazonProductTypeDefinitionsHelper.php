<?php

namespace App\Helpers\Amazon;

use Illuminate\Support\Facades\Config;

class AmazonProductTypeDefinitionsHelper
{
    /**
     * Returns array of attributes with the needed parameters to be filled.
     *
     * @param array $productType
     * @return array
     */
    public static function getSchemaAccordingToProductType($productType)
    {
        $schemaFromJsonFile =  Config::get("amazonscheme");

        return $schemaFromJsonFile[$productType] ?? [];
    }
}
