<?php

namespace App\Jobs\Amazon\SendToAmazonJobs;

use Exception;
use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Helpers\Application\ErrorLogger;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Helpers\Amazon\AmazonSkuBuilderHelper;
use romanzipp\QueueMonitor\Traits\IsMonitored;
use App\Application\Getter\Products\ProductsGetter;
use SellingPartnerApi\Api\ListingsV20210801Api;
use App\Helpers\Amazon\AmazonConfigBuilderHelper;
use App\Helpers\Amazon\AmazonBuildProductPropertiesObjectHelper;
use SellingPartnerApi\Model\ListingsV20210801\ListingsItemPutRequest;

class SendProductsToAmazon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    public const AMAZON_LISTING_TYPE = 'LISTING';

    public $timeout = 360000;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Starts the jobs process which gets the products from Application and start the Amazon object that would be sent to it.
     *
     * @return void
     */
    public function handle()
    {
        $productsFromApplication = (new ProductsGetter($this->user))->setRuleQuery('product.status = true')->setRuleSortBy('product.name', 0)->setRuleSortBy('product.last.update', 0)->getProductsArray(1);
        foreach ($productsFromApplication as $product) {
            foreach ($product->getProductVariants() as $variant) {
                try {
                    $amazonProductProperties = new AmazonBuildProductPropertiesObjectHelper($product, $variant, $this->user->setting, $this->user);
                    $amazonProductProperties = $amazonProductProperties->buildAmazonObject($product->getProductType());
                    if (!$amazonProductProperties) {
                        continue;
                    }
                    $amazonProductObject = (new ListingsItemPutRequest())->setAttributes($amazonProductProperties)->setProductType($product->getProductType())->setRequirements(self::AMAZON_LISTING_TYPE);
                    $result = $this->sendRequestToAmazon($amazonProductObject, AmazonSkuBuilderHelper::buildAmazonSku($product, $variant));
                    dd($result);
                } catch (\Throwable $th) {
                    ErrorLogger::logError($th, $this->user->store_id);
                    dd($th);
                    return false;
                }
            }
        }
    }

    /**
     * Send the products built from Application to Amazon Request through the "jlevers/selling-partner-api" SellingPartnerApi package.
     *
     * @return void
     */
    private function sendRequestToAmazon($amazonProductObject, $sku)
    {
        try {
            $amazonApiInstance = new ListingsV20210801Api(AmazonConfigBuilderHelper::config($this->user));
            return $amazonApiInstance->putListingsItem($this->user->setting->SELLER_ID, $sku, $this->user->setting->MARKET_PLACE_ID, $amazonProductObject);
        } catch (Exception $th) {
            ErrorLogger::logError($th, $this->user->store_id);
            return false;
        }
    }
}
