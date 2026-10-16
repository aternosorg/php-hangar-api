# Aternos\HangarApi\PlatformVersionsApi

All URIs are relative to https://hangar.papermc.io, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getPlatformVersions()**](PlatformVersionsApi.md#getPlatformVersions) | **GET** /api/v1/platforms/{platform}/versions | Gets a list of versions for a platform |


## `getPlatformVersions()`

```php
getPlatformVersions($platform): \Aternos\HangarApi\Model\PlatformVersion[]
```

Gets a list of versions for a platform

Gets a list of platform versions, including children.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\PlatformVersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$platform = new \Aternos\HangarApi\Model\\Aternos\HangarApi\Model\Platform(); // \Aternos\HangarApi\Model\Platform | The platform to get versions for

try {
    $result = $apiInstance->getPlatformVersions($platform);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PlatformVersionsApi->getPlatformVersions: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **platform** | [**\Aternos\HangarApi\Model\Platform**](../Model/.md)| The platform to get versions for | |

### Return type

[**\Aternos\HangarApi\Model\PlatformVersion[]**](../Model/PlatformVersion.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `*/*`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
