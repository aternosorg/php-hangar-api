# Aternos\HangarApi\APIKeysApi

All URIs are relative to https://hangar.papermc.io, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**createKey()**](APIKeysApi.md#createKey) | **POST** /api/v1/keys | Creates an API key |
| [**deleteKey()**](APIKeysApi.md#deleteKey) | **DELETE** /api/v1/keys | Deletes an API key |
| [**getKeys()**](APIKeysApi.md#getKeys) | **GET** /api/v1/keys | Fetches a list of API Keys |


## `createKey()`

```php
createKey($create_api_key_form): string
```

Creates an API key

Creates an API key. Requires the `edit_api_keys` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\APIKeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$create_api_key_form = new \Aternos\HangarApi\Model\CreateAPIKeyForm(); // \Aternos\HangarApi\Model\CreateAPIKeyForm

try {
    $result = $apiInstance->createKey($create_api_key_form);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling APIKeysApi->createKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **create_api_key_form** | [**\Aternos\HangarApi\Model\CreateAPIKeyForm**](../Model/CreateAPIKeyForm.md)|  | |

### Return type

**string**

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `text/plain`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `deleteKey()`

```php
deleteKey($name)
```

Deletes an API key

Deletes an API key. Requires the `edit_api_keys` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\APIKeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$name = 'name_example'; // string | The name of the key to delete

try {
    $apiInstance->deleteKey($name);
} catch (Exception $e) {
    echo 'Exception when calling APIKeysApi->deleteKey: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **name** | **string**| The name of the key to delete | |

### Return type

void (empty response body)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getKeys()`

```php
getKeys(): \Aternos\HangarApi\Model\ApiKey[]
```

Fetches a list of API Keys

Fetches a list of API Keys. Requires the `edit_api_keys` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\APIKeysApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->getKeys();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling APIKeysApi->getKeys: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\Aternos\HangarApi\Model\ApiKey[]**](../Model/ApiKey.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
