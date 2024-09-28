<?php

namespace App\Helpers\Amazon;

use SellingPartnerApi\Endpoint;
use SellingPartnerApi\Configuration;
use Illuminate\Support\Facades\Config;

class AmazonConfigBuilderHelper
{
    public static function config($user)
    {
        return  new Configuration(
            [
                "lwaClientId" => $user->setting->LWA_CLIENT_ID,
                "lwaClientSecret" =>  $user->setting->LWA_CLIENT_SECRET,
                "lwaRefreshToken" =>  $user->setting->LWA_REFRESH_TOKEN,
                "awsAccessKeyId" =>  $user->setting->AWS_ACCESS_KEY,
                "awsSecretAccessKey" =>  $user->setting->AWS_SECRET_ACCESS_KEY,
                "roleArn" => $user->setting->AWS_ROLE_ARN,
                "endpoint" => Endpoint::NA
            ]
        );
    }

    public static function awsConfig($user)
    {
        Config::set("filesystems.s3.driver", 's3');
        Config::set("filesystems.s3.key", $user->setting->AWS_ACCESS_KEY);
        Config::set("filesystems.s3.secret", $user->setting->AWS_SECRET_ACCESS_KEY);
        Config::set("filesystems.s3.region", $user->setting->AWS_DEFAULT_REGION);
        Config::set("filesystems.s3.bucket", $user->setting->AWS_BUCKET);
        Config::set("filesystems.s3.url", $user->setting->AWS_URL);
        Config::set("filesystems.s3.endpoint", Endpoint::NA);
        Config::set("filesystems.s3.use_path_style_endpoint", false);
        Config::set("filesystems.s3.throw", false);

        return [
            Config::get("filesystems.s3.driver"),
            Config::get("filesystems.s3.key"),
            Config::get("filesystems.s3.secret"),
            Config::get("filesystems.s3.region"),
            Config::get("filesystems.s3.bucket"),
            Config::get("filesystems.s3.url"),
            Config::get("filesystems.s3.endpoint"),
            Config::get("filesystems.s3.use_path_style_endpoint"),
            Config::get("filesystems.s3.throw")
        ];
    }

}
