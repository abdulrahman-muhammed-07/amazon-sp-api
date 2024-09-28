<?php

namespace App\Helpers\Application;

class MetaData
{
    public static function get($storeId, $dev = false)
    {
        if ($dev) {

            return array(
                "x-forwarded-for" => ["127.0.0.1"],
                "x-client-id" => ['1'],
                "internal_client_id" => ['1'],
                "x-is-testing" => ['true']
            );
        }

        return array(
            'authorization' => array('Bearer ' . AccessToken::getAccessToken($storeId)),
            'x-client-id' => array((string)$storeId)
        );
    }
}
