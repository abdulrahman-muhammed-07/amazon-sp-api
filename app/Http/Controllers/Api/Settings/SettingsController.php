<?php

namespace App\Http\Controllers\Api\Settings;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\AmazonRequest;

class SettingsController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $userSetting = $user->setting;

            if ($userSetting) {
                return response()->json(['setting' => $userSetting], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Settings not found'], Response::HTTP_NOT_FOUND);
            }
        } else {
            return response()->json(['message' => 'User not authenticated'], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'setting.LWA_CLIENT_ID' => 'required',
                'setting.LWA_CLIENT_SECRET' => 'required',
                'setting.AWS_ACCESS_KEY' => 'required',
                'setting.AWS_SECRET_ACCESS_KEY' => 'required',
                'setting.AWS_DEFAULT_REGION' => 'required',
                'setting.AWS_BUCKET' => 'required',
                // 'setting.LWA_ACCESS_TOKEN' => 'required',
                'setting.LWA_REFRESH_TOKEN' => 'required',
                'setting.AWS_ROLE_ARN' => 'required',
                'setting.DEVELOPER_ID' => 'required',
                // 'setting.ASIN' => 'required',
                'setting.AMAZON_APP_ID' => 'required',
                'setting.MARKET_PLACE_ID' => 'required',
                'setting.SELLER_ID' => 'required',
                'setting.REPORT_TYPE' => 'required',
            ]
        );

        $user = $request->user();

        if ($user) {
            $userSetting = $user->setting()->updateOrCreate([], $validatedData['setting']);

            if ($userSetting) {
                return response()->json(['message' => 'Settings saved successfully'], Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'Failed to save settings'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return response()->json(['message' => 'User not authenticated'], Response::HTTP_UNAUTHORIZED);
        }
    }
}