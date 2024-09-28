<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Closure;

class ValidateStoreId
{
    public function handle($request, Closure $next)
    {
        if (!$request->has('store_id') && isset($request->user()->store_id)) {
            $request->merge(['store_id' => $request->user()->store_id]);
        }

        if ($request->has('store_id')) {
            $store_id = $request->input('store_id');
            $user = User::where('store_id', $store_id)->first();

            if ($user) {
                Auth::login($user);
                $request->merge(['user' => $user]);
            }
        }

        $request->validate([
            'store_id' => 'required|exists:users,store_id',
        ]);

        return $next($request);
    }
}
