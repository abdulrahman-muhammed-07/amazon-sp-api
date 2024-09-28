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

            Http::post('https://hooks.slack.com/services/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', [
                'text' => '<!everyone> Help ! I can\'t get an Access token in ' . $user->name . ' store, click  <' . $link . ' | Here> to help this ' .  $appName
            ]);
        }

        return true;
    }
}
