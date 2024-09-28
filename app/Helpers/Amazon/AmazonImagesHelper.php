<?php

namespace App\Helpers\Amazon;

use Aws\S3\S3Client;
use Illuminate\Support\Str;
use App\Helpers\Application\ErrorLogger;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AmazonImagesHelper
{
    public static function getImageLinkOnAmazon($user, $product,  $variant): ?string
    {
        $imageUlrFromApplication = self::getAvailableImageFOrProduct($product,  $variant);
        try {
            AmazonConfigBuilder::awsConfig($user);
            $path = self::getImageMediaLocationBucketAmazonTest($imageUlrFromApplication, $product->getProductName() ?? rand(20));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $user->store_id);
            $path = null;
        }
        return $path;
    }

    public static function getImageMediaLocationBucketAmazonTest($imagLink, $productName)
    {
        try {
            $contents = file_get_contents(
                $imagLink
            );
            $s3 = new S3Client(['region'  => 'us-east-1', 'version' => 'latest', 'credientials' => ['key' => 'AKIARU2ZL4MQQPJCMLGX', 'secret' =>  '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']]);
            $folderName = 'images';
            $slugName = Str::slug($productName);
            $key =  $folderName . '/' . "$slugName.png";
            $result = $s3->putObject(['Bucket' => 'mynewawsbucketApplication', 'path' => 'images', 'Key'    => $key, 'Body'   =>  $contents]);
            $path = 'https://mynewawsbucketApplication.s3.amazonaws.com/' . $key;
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, 1);
            $path = null;
        }
        return $path;
    }

    public static function getImageMediaLocationBucketAmazon($user, $product, $variant)
    {
        $imageUlrFromApplication = self::getAvailableImageFOrProduct($product, $variant);
        $localImagePath = storage_path('app/temp_image.jpg');
        $response = Http::get($imageUlrFromApplication);
        file_put_contents($localImagePath, $response->body());
        try {
            AmazonConfigBuilder::awsConfig($user);
            $destinationPath = 'uploads/new_location/';
            $path = Storage::disk('s3')->put($destinationPath,  file_get_contents($localImagePath));
            $path = Storage::disk('s3')->url($path);
            unlink($localImagePath);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $user->store_id);
            $path = null;
        }
        return $path;
    }

    private static function getAvailableImageFOrProduct($product,  $variant): ?string
    {
        foreach ($product->getProductImages() as $image) {
            if ($image != null) {
                return $image;
            }
        }
        if (!empty($variant->getVariantImage())) {
            return $variant->getVariantImage();
        }
        return null;
    }
}
