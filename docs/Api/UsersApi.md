# Aternos\HangarApi\UsersApi

All URIs are relative to https://hangar.papermc.io, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getAuthors()**](UsersApi.md#getAuthors) | **GET** /api/v1/authors | Returns all users with at least one public project |
| [**getStaff()**](UsersApi.md#getStaff) | **GET** /api/v1/staff | Returns Hangar staff |
| [**getUser()**](UsersApi.md#getUser) | **GET** /api/v1/users/{user} | Returns a specific user |
| [**getUserPinnedProjects()**](UsersApi.md#getUserPinnedProjects) | **GET** /api/v1/users/{user}/pinned | Returns the pinned projects for a specific user |
| [**getUserWatching()**](UsersApi.md#getUserWatching) | **GET** /api/v1/users/{user}/watching | Returns the watched projects for a specific user |
| [**showStarred()**](UsersApi.md#showStarred) | **GET** /api/v1/users/{user}/starred | Returns the starred projects for a specific user |
| [**showUsers()**](UsersApi.md#showUsers) | **GET** /api/v1/users | Searches for users |


## `getAuthors()`

```php
getAuthors($query, $sort, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultUser
```

Returns all users with at least one public project

Returns all users that have at least one public project. Requires the `view_public_info` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$query = 'query_example'; // string | The search query
$sort = 'sort_example'; // string | Used to sort the result
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->getAuthors($query, $sort, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->getAuthors: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **query** | **string**| The search query | |
| **sort** | **string**| Used to sort the result | [optional] |
| **limit** | **string**| The maximum amount of items to return | [optional] |
| **offset** | **string**| Where to start searching | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PaginatedResultUser**](../Model/PaginatedResultUser.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getStaff()`

```php
getStaff($query, $sort, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultUser
```

Returns Hangar staff

Returns Hanagr staff. Requires the `view_public_info` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$query = 'query_example'; // string | The search query
$sort = 'sort_example'; // string | Used to sort the result
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->getStaff($query, $sort, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->getStaff: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **query** | **string**| The search query | |
| **sort** | **string**| Used to sort the result | [optional] |
| **limit** | **string**| The maximum amount of items to return | [optional] |
| **offset** | **string**| Where to start searching | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PaginatedResultUser**](../Model/PaginatedResultUser.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getUser()`

```php
getUser($user): \Aternos\HangarApi\Model\User
```

Returns a specific user

Returns a specific user. Requires the `view_public_info` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user = 'user_example'; // string | The name or id of the user to return

try {
    $result = $apiInstance->getUser($user);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->getUser: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user** | **string**| The name or id of the user to return | |

### Return type

[**\Aternos\HangarApi\Model\User**](../Model/User.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getUserPinnedProjects()`

```php
getUserPinnedProjects($user): \Aternos\HangarApi\Model\ProjectCompact[]
```

Returns the pinned projects for a specific user

Returns the pinned projects for a specific user. Requires the `view_public_info` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user = 'user_example'; // string | The name or id of the user to return pinned projects for

try {
    $result = $apiInstance->getUserPinnedProjects($user);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->getUserPinnedProjects: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user** | **string**| The name or id of the user to return pinned projects for | |

### Return type

[**\Aternos\HangarApi\Model\ProjectCompact[]**](../Model/ProjectCompact.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getUserWatching()`

```php
getUserWatching($user, $sort, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultProjectCompact
```

Returns the watched projects for a specific user

Returns the watched projects for a specific user. Requires the `view_public_info` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user = 'user_example'; // string | The name or id of the user to return watched projects for
$sort = 'sort_example'; // string | Used to sort the result
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->getUserWatching($user, $sort, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->getUserWatching: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user** | **string**| The name or id of the user to return watched projects for | |
| **sort** | **string**| Used to sort the result | [optional] |
| **limit** | **string**| The maximum amount of items to return | [optional] |
| **offset** | **string**| Where to start searching | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PaginatedResultProjectCompact**](../Model/PaginatedResultProjectCompact.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `showStarred()`

```php
showStarred($user, $sort, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultProjectCompact
```

Returns the starred projects for a specific user

Returns the starred projects for a specific user. Requires the `view_public_info` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$user = 'user_example'; // string | The name or id of the user to return starred projects for
$sort = 'sort_example'; // string | Used to sort the result
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->showStarred($user, $sort, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->showStarred: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **user** | **string**| The name or id of the user to return starred projects for | |
| **sort** | **string**| Used to sort the result | [optional] |
| **limit** | **string**| The maximum amount of items to return | [optional] |
| **offset** | **string**| Where to start searching | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PaginatedResultProjectCompact**](../Model/PaginatedResultProjectCompact.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `showUsers()`

```php
showUsers($query, $sort, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultUser
```

Searches for users

Returns a list of users based on a search query. Requires the `view_public_info` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\UsersApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$query = 'query_example'; // string | The search query
$sort = 'sort_example'; // string | Used to sort the result
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->showUsers($query, $sort, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UsersApi->showUsers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **query** | **string**| The search query | |
| **sort** | **string**| Used to sort the result | [optional] |
| **limit** | **string**| The maximum amount of items to return | [optional] |
| **offset** | **string**| Where to start searching | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PaginatedResultUser**](../Model/PaginatedResultUser.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
