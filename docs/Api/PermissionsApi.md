# Aternos\HangarApi\PermissionsApi

All URIs are relative to https://hangar.papermc.io, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**hasAll()**](PermissionsApi.md#hasAll) | **GET** /api/v1/permissions/hasAll | Checks whether you have all the provided permissions |
| [**hasAny()**](PermissionsApi.md#hasAny) | **GET** /api/v1/permissions/hasAny | Checks whether you have at least one of the provided permissions |
| [**showPermissions()**](PermissionsApi.md#showPermissions) | **GET** /api/v1/permissions | Returns your permissions |


## `hasAll()`

```php
hasAll($permissions, $slug, $organization, $project): \Aternos\HangarApi\Model\PermissionCheck
```

Checks whether you have all the provided permissions

Checks whether you have all the provided permissions in the given context

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\PermissionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$permissions = array(new \Aternos\HangarApi\Model\\Aternos\HangarApi\Model\NamedPermission()); // \Aternos\HangarApi\Model\NamedPermission[] | The permissions to check
$slug = 'slug_example'; // string | Deprecated alias for `project`
$organization = 'organization_example'; // string | The id or name of the organization to check permissions in. Must not be used together with `slug`
$project = 'project_example'; // string | The id or slug of the project to check permissions in. Must not be used together with `organization`

try {
    $result = $apiInstance->hasAll($permissions, $slug, $organization, $project);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PermissionsApi->hasAll: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **permissions** | [**\Aternos\HangarApi\Model\NamedPermission[]**](../Model/\Aternos\HangarApi\Model\NamedPermission.md)| The permissions to check | |
| **slug** | **string**| Deprecated alias for &#x60;project&#x60; | [optional] |
| **organization** | **string**| The id or name of the organization to check permissions in. Must not be used together with &#x60;slug&#x60; | [optional] |
| **project** | **string**| The id or slug of the project to check permissions in. Must not be used together with &#x60;organization&#x60; | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PermissionCheck**](../Model/PermissionCheck.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `hasAny()`

```php
hasAny($permissions, $slug, $organization, $project): \Aternos\HangarApi\Model\PermissionCheck
```

Checks whether you have at least one of the provided permissions

Checks whether you have at least one of the provided permissions in the given context

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\PermissionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$permissions = array(new \Aternos\HangarApi\Model\\Aternos\HangarApi\Model\NamedPermission()); // \Aternos\HangarApi\Model\NamedPermission[] | The permissions to check
$slug = 'slug_example'; // string | Deprecated alias for `project`
$organization = 'organization_example'; // string | The id or name of the organization to check permissions in. Must not be used together with `project`
$project = 'project_example'; // string | The id or slug of the project to check permissions in. Must not be used together with `organization`

try {
    $result = $apiInstance->hasAny($permissions, $slug, $organization, $project);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PermissionsApi->hasAny: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **permissions** | [**\Aternos\HangarApi\Model\NamedPermission[]**](../Model/\Aternos\HangarApi\Model\NamedPermission.md)| The permissions to check | |
| **slug** | **string**| Deprecated alias for &#x60;project&#x60; | [optional] |
| **organization** | **string**| The id or name of the organization to check permissions in. Must not be used together with &#x60;project&#x60; | [optional] |
| **project** | **string**| The id or slug of the project to check permissions in. Must not be used together with &#x60;organization&#x60; | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PermissionCheck**](../Model/PermissionCheck.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `showPermissions()`

```php
showPermissions($slug, $organization, $project): \Aternos\HangarApi\Model\UserPermissions
```

Returns your permissions

Returns a list of permissions you have in the given context

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\PermissionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug = 'slug_example'; // string | Deprecated alias for `project`
$organization = 'organization_example'; // string | The id or name of the organization to check permissions in. Must not be used together with `project`
$project = 'project_example'; // string | The id or slug of the project to check permissions in. Must not be used together with `organization`

try {
    $result = $apiInstance->showPermissions($slug, $organization, $project);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PermissionsApi->showPermissions: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug** | **string**| Deprecated alias for &#x60;project&#x60; | [optional] |
| **organization** | **string**| The id or name of the organization to check permissions in. Must not be used together with &#x60;project&#x60; | [optional] |
| **project** | **string**| The id or slug of the project to check permissions in. Must not be used together with &#x60;organization&#x60; | [optional] |

### Return type

[**\Aternos\HangarApi\Model\UserPermissions**](../Model/UserPermissions.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
