<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\CodeRequest;
use App\Http\Controllers\Controller;
use App\Helpers\Application\GetExpiryDate;
use League\OAuth2\Client\Provider\GenericProvider;

class CodeController extends Controller
{
    public function __construct(public GenericProvider $provider)
    {
        $this->middleware(['auth:api']);
    }

    public function action(CodeRequest $request)
    {
        return $this->getAccessToken($request);
    }

    protected function getAccessToken(CodeRequest $request)
    {
        try {
            $accessToken = $this->provider->getAccessToken('authorization_code', [
                'code' => $request->code,

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
        $request->user()->oauth()->updateOrCreate(['user_store_id' => $request->user()->store_id], [
            'access_token' => $accessToken->getToken(),
            'refresh_token' => $accessToken->getRefreshToken(),
            'expiry_date' => $accessToken->getExpires()
        ]);
        $request->user()->state()->delete();
        return response()->json([
            'acknowledge' => true,
            'plugin_origin' => env('PLUGIN_ORIGIN'),
            'expiry' => GetExpiryDate::get($request->user()),
            'plugin_code' => env('PLUGIN_CODE')
        ]);
    }
}
