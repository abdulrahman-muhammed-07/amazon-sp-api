# AMAZON APPLICATION DOCUMENTATION

- [Introduction](#introduction)
- [Configuration of API for the Selling Partner API (SP_API)](#configuration-of-api-for-the-selling-partner-api-sp_api)
  - [lwaClientId, lwaClientSecret, and lwaRefreshToken](#lwaclientid-lwaclientsecret-and-lwarefreshtoken)
  - [awsAccessKeyId, awsSecretAccessKey, and roleArn](#awsaccesskeyid-awssecretaccesskey-and-rolearn)
- [Example Configuration Code](#example-configuration-code)

## Introduction

**For Using the application you need access to Amazon Selling partner account and for the AWS Console management developer account**

## Configuration of API for the Selling Partner API (SP_API)

We are using the [jlevers/selling-partner-api package](https://github.com/jlevers/selling-partner-api) for the configuration of the API.

### lwaClientId, lwaClientSecret, and lwaRefreshToken

The `lwaClientId`, `lwaClientSecret`, and `lwaRefreshToken` are obtained from the Sell Central Developer Console portal. You can access this portal by visiting the following URL: [Sell Central Developer Console](https://sellercentral.amazon.com/sellingpartner/developerconsole/ref=xx_DevCon_dnav_xx#).

For more detailed information on obtaining these credentials, please refer to the [documentation](https://developer-docs.amazon.com/sp-api/docs/rotating-your-apps-lwa-credentials).

### awsAccessKeyId, awsSecretAccessKey, and roleArn

The `awsAccessKeyId`, `awsSecretAccessKey`, and `roleArn` are obtained from the AWS Services Developer Console. You can access this console by visiting the following URL: [AWS Services Developer Console](https://console.aws.amazon.com/iam).

For more detailed information on obtaining these credentials, please refer to the [documentation](https://docs.aws.amazon.com/powershell/latest/userguide/pstools-appendix-sign-up.html).

## Example Configuration Code

```php
use SellingPartnerApi\Endpoint;
use SellingPartnerApi\Configuration;

class AmazonConfigBuilder
{
    public static function config($user)
    {
        $config = new Configuration(
            [
                "lwaClientId" => $user->setting->LWA_CLIENT_ID,
                "lwaClientSecret" =>  $user->setting->LWA_CLIENT_SECRET,
                "lwaRefreshToken" =>  $user->setting->LWA_REFRESH_TOKEN,
                "awsAccessKeyId" =>  $user->setting->AWS_ACCESS_KEY,
                "awsSecretAccessKey" =>  $user->setting->AWS_SECRET_ACCESS_KEY,
                "roleArn" => $user->setting->AWS_ROLE_ARN,
                "endpoint" => Endpoint::NA
            ]
        );

        return $config;
    }
}
```
