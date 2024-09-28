<?php

namespace App\Helpers\Amazon;

use App\Models\User;

class AmazonAccessTokenHelper
{
    public static function getAmazonNewAccessToken(User $user)
    {
        $auhUrlEndPoint = 'https://api.amazon.com/auth/o2/token';

        $refreshToken = env('LWA_refresh_token');

        $grantType = 'refresh_token';

        $scope = 'sellingpartnerapi::migration';

        $userSettings = $user->setting;

        $lwaClientId = $userSettings->LWA_CLIENT_ID;

        $lwaClientSecret = $userSettings->LWA_CLIENT_SECRET;

        $params = http_build_query([
            'grant_type' => $grantType,
            'refresh_token' => $refreshToken,
            'client_id' => $lwaClientId,
            'client_secret' => $lwaClientSecret,
            'scope' => $scope
        ]);

        $redirectUri =  $auhUrlEndPoint . '?' . $params;

        $ch = curl_init($redirectUri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        $response = json_decode($response, true);

        curl_close($ch);

        if (isset($response['access_token'])) {
            $response['expires_in'] += time();
        } else {
            return false;
        }
    }
}
