<?php

namespace App\Jobs\Amazon\GetFromAmazonJobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Helpers\Amazon\AmazonConfigBuilderHelper;
use SellingPartnerApi\Api\ProductTypeDefinitionsV20200901Api;

class GetAllProductTypesSchemesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userSettings;

    public function __construct(public User $user)
    {
        $this->userSettings = $user->setting;
    }

    public function handle()
    {
        $amazonApiInstance = new ProductTypeDefinitionsV20200901Api(AmazonConfigBuilderHelper::config($this->user));

        $types = $this->getProductTypesArray();

        // foreach ($types as $productType) {

        $result = $amazonApiInstance->getDefinitionsProductType("COAT", $this->userSettings->MARKET_PLACE_ID , requirements_enforced:'ENFORCED');

        $urlToCall = $result->getSchema()->getLink()->getResource();

        $schemaRequest = Http::get($urlToCall);

        $productTypeArray = ($schemaRequest->json());

        $requiredValues = $productTypeArray['required'];

        $propertiesOfValues = $productTypeArray['properties'];

        $AllOFConditions = $productTypeArray['allOf'];

        dd(json_encode($requiredValues));
        // }
    }

    private function getProductTypesArray()
    {
        return json_decode(
            '[
                "APPAREL",
                "COAT",
                "SHORTS",
                "SWEATER",
                "SKIRT",
                "SHOES",
                "BABY_PRODUCT",
                "PANTS",
                "SHIRT",
                "NECKTIE",
                "ANTENNA",
                "WIRELESS_ACCESSORY",
                "WIRELESS_SIGNAL REPEATER",
                "NOTEBOOK_COMPUTER",
                "ELECTRONIC_DEVICE_DOCKING_STATION",
                "COMPUTER_DRIVE_OR_STORAGE",
                "HARD_DRIVE_ENCLOSURE",
                "MOUNT_BRACKET",
                "COMPUTER_ADD_ON",
                "SYSTEM_POWER_DEVICE",
                "LAB_SUPPLY",
                "ELECTRONIC_FINDER",
                "GPS_OR_NAVIGATION_SYSTEM",
                "LOCATION_TRACKER",
                "MONITOR",
                "FLASH_MEMORY",
                "PORTABLE_ELECTRONIC_DEVICE_STAND",
                "VIRTUAL_REALITY_HEADSET",
                "PHYSICAL_SOFTWARE",
                "SECURITY_SYSTEM",
                "MOTION_DETECTOR_DEVICE",
                "SURVEILANCE_SYSTEMS",
                "SURVEILLANCE_RECORDER_SYSTEM",
                "OFFICE_ELECTRONICS",
                "KEYBOARDS",
                "MICROPHONE",
                "ELECTRICITY_GENERATOR",
                "POWER_BANK",
                "SOLAR_PANEL",
                "HEADPHONES",
                "ELECTRONIC_CABLE",
                "AUTO_PART",
                "IGNITION_COIL",
                "RADAR_DETECTOR",
                "LAMP",
                "LIGHT_FIXTURE",
                "VEHICLE_LIGHT_BULB",
                "STRING_LIGHT",
                "HOME_LIGHTING_AND_LAMPS",
                "ELECTRIC_LIGHT",
                "ABIS_BOOK",
                "STORAGE_RACK",
                "ANIMAL_SHELTER",
                "PET_TOY",
                "PET_SUPPLIES",
                "AUTO_OIL",
                "FOOD",
                "GROCERY",
                "PACKAGED_SOUP_AND_STEW",
                "COOKIE",
                "NUT_AND_SEED",
                "FRUIT_SNACK",
                "FRUIT",
                "JUICE_AND_JUICE_DRINK",
                "WATER",
                "COFFEE",
                "TEA",
                "FLAVORED_DRINK_CONCENTRATE",
                "PROTEIN_DRINK",
                "DAIRY_BASED_DRINK",
                "EDIBLE_OIL_VEGETABLE"
            ]',
            true
        );
    }
}
