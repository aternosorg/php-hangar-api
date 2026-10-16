# Aternos\HangarApi\AuthenticationApi

All URIs are relative to https://hangar.papermc.io, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**authenticate()**](AuthenticationApi.md#authenticate) | **POST** /api/v1/authenticate | Creates an API JWT |


## `authenticate()`

```php
authenticate($api_key): \Aternos\HangarApi\Model\ApiSession
```

Creates an API JWT

`Log-in` with your API key in order to be able to call other endpoints authenticated. The returned JWT should be specified as a header in all following requests: `Authorization: HangarAuth your.jwt`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\AuthenticationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$api_key = 'api_key_example'; // string | JWT

try {
    $result = $apiInstance->authenticate($api_key);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthenticationApi->authenticate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **api_key** | **string**| JWT | |

### Return type

[**\Aternos\HangarApi\Model\ApiSession**](../Model/ApiSession.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
