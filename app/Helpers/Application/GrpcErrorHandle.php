<?php

namespace App\Helpers\Application;

use Exception;
use LogicException;
use App\Models\User;
use App\Models\Oauth;

class GrpcErrorHandle
{
    public static function checkGrpcErrors(array $waitedArray, int $storeId): bool
    {
        if ($waitedArray[1]->code == 16 || $waitedArray[1]->code == 2) {

            $store = Oauth::where('user_store_id', '=', $storeId)->first() ?: '';

            if (!empty($store)) {

                $th = throw new LogicException($waitedArray[1]->message);

                ErrorLogger::logError($th, $storeId);

                $user = User::where('store_id', '=', $storeId)->first();

                ReportAccessTokenExpiry::report($user, $waitedArray[1]->details);
            }

            $return = false;
        } elseif ($waitedArray[0] == null) {

            $message = $waitedArray[1]->details;

            $code = $waitedArray[1]->code;

            if (
                $message == 'no customers available' ||
                $message == 'no products available' ||
                $message == 'no product\/variant update is needed' ||
                $message == 'no product variant update is needed'
            ) {
                $return = false;
            }

            $th = new Exception($message, $code);

            ErrorLogger::logError($th, $storeId);

            $return = false;
        } elseif ($waitedArray[0]->getFailure()) {

            $code = $waitedArray[0]->getCode();

            $message = $waitedArray[0]->getMessage();

            if (
                $message == 'no customers available' ||
                $message == 'no products available' ||
                $message == 'no product\/variant update is needed' ||
                $message == 'no product variant update is needed'
            ) {
                $return = false;
            }

            $th = new Exception($message, $code);

            ErrorLogger::logError($th, $storeId);

            $return = false;
        } else {
            $return = true;
        }

        return $return;
    }
}
