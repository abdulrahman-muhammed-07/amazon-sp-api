<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Helpers\Application\AccessToken;
use App\Http\Controllers\Controller;
use App\Helpers\Application\GetExpiryDate;
use App\Http\Requests\RegisterFormRequest;
use App\Http\Resources\PrivateUserResource;
use League\OAuth2\Client\Provider\GenericProvider;

class LoginController extends Controller
{
    public function __construct(public GenericProvider $provider)
    {
        //
    }

    public function action(RegisterFormRequest $request)
    {
        User::firstOrCreate([
            'email' => $request->safe()->extra['admin_email'],
            'store_id' => $request->safe()->store_id
        ], [
            'password' => $request->safe()->password,
            'name' => $request->safe()->extra['admin_name']
        ]);

        $user = User::where('store_id',  $request->safe()->store_id)->first();

        if (!$token = auth()->attempt([
            'email' => $request->safe()->extra['admin_email'],
            'password' => $request->safe()->password
        ])) {

            return response()->json([
                'errors' => ['email' => 'Couldn\'t sign you in with these credentials']
            ], 422);
        }

        if (isset($user->oauth->expiry_date) && time() > (int) $user->oauth->expiry_date - 300) {
            if (env("ACCESS_TOKEN_SOURCE") == 'Proxy') {
                AccessToken::newProxyAccessToken($user->store_id);
            } else {
                AccessToken::newProviderAccessToken($user->store_id);
            }
        }

        $user = $user->fresh();

        $request->user()->state()->delete();

        return (new PrivateUserResource($user))
            ->additional([
                'meta' => [
                    'token' => $token,
                    'plugin_origin' => env('PLUGIN_ORIGIN'),
                    'expiry' => GetExpiryDate::get($user),
                    'plugin_code' => env('PLUGIN_CODE')
                ] + $this->getAuthUrl($user)
            ]);
    }

    protected function getAuthUrl(User $user)
    {
        $user->fresh();

        $options = [
            'scope' => [env('SCOPE')],
            'access_type' => env('ACCESS_TYPE'),
            'plugin_code' => env('PLUGIN_CODE'),
        ];

        $url = $this->provider->getAuthorizationUrl($options);

        $user->state()->updateOrCreate(['user_store_id' => $user->store_id], [
            'state' => md5($this->provider->getState()),
            'expiry_date' => time() + 300
        ]);

        $redirect = true;

        if (isset($user->oauth) && ($user->oauth->access_token != null)) {
            $redirect = false;
        }

        return ['authUrl' => $url, 'redirect' => $redirect];
    }
}
