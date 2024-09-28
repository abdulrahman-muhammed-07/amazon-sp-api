<?php

namespace App\Helpers\Application;

use Illuminate\Support\Facades\Http;

class ReportAccessTokenExpiry
{
    public static function report($user)
    {
        if (env("REPORT_TOKENS_EXPIRY")) {

            $link = env('PLUGIN_LINK');

            $appName = env('APP_NAME');
        }

        return true;
    }
}
