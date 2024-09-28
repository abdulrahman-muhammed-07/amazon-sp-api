<?php

namespace App\Http\Controllers\Api\Settings;

use App\Models\Log;
use App\Models\User;
use App\Models\Oauth;
use App\Models\State;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Client;
use App\Models\SyncDetail;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use App\Helpers\Application\ErrorLogger;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Request as GuzzleHttp;

class UnInstallController extends Controller
{
    public function uninstall(Request $request)
    {
        $decoded = JWT::decode($request->session_token, new Key(env('APP_SECRET'), ('HS256')));
        $payload = json_decode(json_encode($decoded), true);
        $storeId = (int)$payload['store_id'];
        Oauth::where('user_store_id', '=', $storeId)->delete();
        State::where('user_store_id', '=', $storeId)->delete();
        // User:where('store_id',storeId)->delete();
        // // SyncDetail::where('id', '=', md5($storeId . 'products'))->delete();
        // // SyncDetail::where('id', '=', md5($storeId . 'categories'))->delete();
        // // SyncDetail::where('id', '=', md5($storeId . 'pages'))->delete();
        $this->removeClientIdFromProxyRequest($storeId);
    }

    private function removeClientIdFromProxyRequest($storeId)
    {
        $client = new Client();
        $clientId = env("APP_CLIENT_ID");
        try {
            $curlGetAccessTokenRequest = new GuzzleHttp('GET', "http://localhost:3333/clear?client_id=$clientId&store_id=$storeId");
            $client->sendAsync($curlGetAccessTokenRequest)->wait();
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $storeId);
            return false;
        }
    }
}
