<?php

namespace App\Helpers\Amazon;

class AmazonBuildProductPropertiesObjectHelper
{
    public array $productArray;

    public array $variantArray;

    public function __construct(public $product, public $variant, public $userSettings, public $user)
    {
        $this->productArray = json_decode($this->product->serializeToJsonString(), true);
        $this->variantArray = json_decode($this->variant->serializeToJsonString(), true);
    }

    public  function buildAmazonObject($productType): ?array
    {
        $valuesToBuildAmazonObjectWith = AmazonProductTypeDefinitionsHelper::getSchemaAccordingToProductType($productType);

        $amazonObject = [];

        foreach ($valuesToBuildAmazonObjectWith as $attributeName => $requiredValues) {
            $amazonObject[$attributeName][] =  $this->matchValuesFromApplication($attributeName, $requiredValues);
        }

        return $amazonObject;
    }

    private function matchValuesFromApplication($attributeName, $requiredValues): ?array
    {
        $objectBuilt = null;

        if (in_array('language_tag', $requiredValues)) {
            $objectBuilt['language_tag'] = 'en_US';
        }
        if (in_array('marketplace_id', $requiredValues)) {
            $objectBuilt['marketplace_id'] =  $this->userSettings->MARKET_PLACE_ID;
        }
        if (in_array('quantity', $requiredValues)) {
            $objectBuilt['quantity'] =  $this->productArray['productTotalQty'] ?? 0;
            $objectBuilt['fulfillment_channel_code'] = 'DEFAULT';
        }
        if (in_array('value', $requiredValues)) {
            $objectBuilt['value'] =  $this->getApplicationValue($attributeName);
        }
        if (in_array('media_location', $requiredValues)) {
            $objectBuilt['media_location'] =  AmazonImagesHelper::getImageLinkOnAmazon($this->user, $this->product, $this->variant);
        }
        if (in_array('length', $requiredValues)) {
            $dimensionType = $this->productArray['productDimType'] ?? 'inches';
            $objectBuilt['length'] =  AmazonDimensionsHelper::buildDimensionsObject($this->variantArray, 'length', $dimensionType);
        }
        if (in_array('width', $requiredValues)) {
            $dimensionType = $this->productArray['productDimType'] ?? 'inches';
            $objectBuilt['width'] =  AmazonDimensionsHelper::buildDimensionsObject($this->variantArray, 'width', $dimensionType);
        }
        if (in_array('height', $requiredValues)) {
            $dimensionType = $this->productArray['productDimType'] ?? 'inches';
            $objectBuilt['height'] =  AmazonDimensionsHelper::buildDimensionsObject($this->variantArray, 'height', $dimensionType);
        }
        return $objectBuilt;
    }

    private function getApplicationValue($valueTOgetFromApplicationObject): ?string
    {
        $value = $this->matchValueArray($valueTOgetFromApplicationObject);

        $ApplicationValue = null;

        if (isset($this->productArray[$value])) {
            $ApplicationValue = $this->productArray[$value];
        } elseif (isset($this->variantArray[$value])) {
            $ApplicationValue = $this->variantArray[$value];
        } elseif (str_contains($value, 'static')) {
            $ApplicationValue = str_replace('_static', '', $value);
        }

        return $ApplicationValue;
    }

    private function matchValueArray($valueTOgetFromApplicationObject)
    {
        $mappingArray = json_decode($this->userSettings->mapping_settings, true);

        return $mappingArray[$valueTOgetFromApplicationObject] ?? null;
    }
}
