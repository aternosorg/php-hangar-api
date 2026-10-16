# Aternos\HangarApi\VersionsApi

All URIs are relative to https://hangar.papermc.io, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**downloadVersion()**](VersionsApi.md#downloadVersion) | **GET** /api/v1/projects/{slugOrId}/versions/{nameOrId}/{platform}/download | Downloads a version |
| [**downloadVersion1()**](VersionsApi.md#downloadVersion1) | **GET** /api/v1/projects/{author}/{slugOrId}/versions/{nameOrId}/{platform}/download |  |
| [**downloadVersionById()**](VersionsApi.md#downloadVersionById) | **GET** /api/v1/versions/{id}/{platform}/download | Downloads a version by its ID |
| [**getLatestReleaseVersion()**](VersionsApi.md#getLatestReleaseVersion) | **GET** /api/v1/projects/{author}/{slugOrId}/latestrelease |  |
| [**getLatestVersion()**](VersionsApi.md#getLatestVersion) | **GET** /api/v1/projects/{author}/{slugOrId}/latest |  |
| [**getVersion()**](VersionsApi.md#getVersion) | **GET** /api/v1/projects/{author}/{slugOrId}/versions/{nameOrId} |  |
| [**getVersionStats()**](VersionsApi.md#getVersionStats) | **GET** /api/v1/projects/{author}/{slugOrId}/versions/{nameOrId}/stats |  |
| [**getVersions()**](VersionsApi.md#getVersions) | **GET** /api/v1/projects/{author}/{slugOrId}/versions |  |
| [**latestReleaseVersion()**](VersionsApi.md#latestReleaseVersion) | **GET** /api/v1/projects/{slugOrId}/latestrelease | Returns the latest release version of a project |
| [**latestVersion()**](VersionsApi.md#latestVersion) | **GET** /api/v1/projects/{slugOrId}/latest | Returns the latest version of a project for a specific channel |
| [**listVersions()**](VersionsApi.md#listVersions) | **GET** /api/v1/projects/{slugOrId}/versions | Returns all versions of a project |
| [**showVersion()**](VersionsApi.md#showVersion) | **GET** /api/v1/projects/{slugOrId}/versions/{nameOrId} | Returns a specific version of a project |
| [**showVersionById()**](VersionsApi.md#showVersionById) | **GET** /api/v1/versions/{id} | Returns a specific version by its ID |
| [**showVersionStats()**](VersionsApi.md#showVersionStats) | **GET** /api/v1/projects/{slugOrId}/versions/{nameOrId}/stats | Returns the stats for a version |
| [**showVersionStatsById()**](VersionsApi.md#showVersionStatsById) | **GET** /api/v1/versions/{id}/stats | Returns the stats for a version by its ID |
| [**uploadVersion()**](VersionsApi.md#uploadVersion) | **POST** /api/v1/projects/{slugOrId}/upload | Creates a new version and returns parts of its metadata |
| [**uploadVersion1()**](VersionsApi.md#uploadVersion1) | **POST** /api/v1/projects/{author}/{slugOrId}/upload |  |


## `downloadVersion()`

```php
downloadVersion($slug_or_id, $name_or_id, $platform): object
```

Downloads a version

Downloads the file for a specific platform of a version. Requires visibility of the project and version.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to download the version from
$name_or_id = 'name_or_id_example'; // string | The name of the version to download
$platform = new \Aternos\HangarApi\Model\\Aternos\HangarApi\Model\Platform(); // \Aternos\HangarApi\Model\Platform | The platform of the version to download

try {
    $result = $apiInstance->downloadVersion($slug_or_id, $name_or_id, $platform);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->downloadVersion: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug_or_id** | **string**| The slug or id of the project to download the version from | |
| **name_or_id** | **string**| The name of the version to download | |
| **platform** | [**\Aternos\HangarApi\Model\Platform**](../Model/.md)| The platform of the version to download | |

### Return type

**object**

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/octet-stream`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `downloadVersion1()`

```php
downloadVersion1($author, $slug_or_id, $name_or_id, $platform): object
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to download the version from
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to download the version from
$name_or_id = 'name_or_id_example'; // string | The name of the version to download
$platform = new \Aternos\HangarApi\Model\\Aternos\HangarApi\Model\Platform(); // \Aternos\HangarApi\Model\Platform | The platform of the version to download

try {
    $result = $apiInstance->downloadVersion1($author, $slug_or_id, $name_or_id, $platform);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->downloadVersion1: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to download the version from | |
| **slug_or_id** | **string**| The slug or id of the project to download the version from | |
| **name_or_id** | **string**| The name of the version to download | |
| **platform** | [**\Aternos\HangarApi\Model\Platform**](../Model/.md)| The platform of the version to download | |

### Return type

**object**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/octet-stream`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `downloadVersionById()`

```php
downloadVersionById($id, $platform): object
```

Downloads a version by its ID

Downloads the file for a specific platform of a version. Requires visibility of the project and version.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$id = 'id_example'; // string | The id of the version to download
$platform = new \Aternos\HangarApi\Model\\Aternos\HangarApi\Model\Platform(); // \Aternos\HangarApi\Model\Platform | The platform of the version to download

try {
    $result = $apiInstance->downloadVersionById($id, $platform);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->downloadVersionById: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| The id of the version to download | |
| **platform** | [**\Aternos\HangarApi\Model\Platform**](../Model/.md)| The platform of the version to download | |

### Return type

**object**

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/octet-stream`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getLatestReleaseVersion()`

```php
getLatestReleaseVersion($author, $slug_or_id): string
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to return the latest version for
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return the latest version for

try {
    $result = $apiInstance->getLatestReleaseVersion($author, $slug_or_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->getLatestReleaseVersion: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to return the latest version for | |
| **slug_or_id** | **string**| The slug or id of the project to return the latest version for | |

### Return type

**string**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `text/plain`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getLatestVersion()`

```php
getLatestVersion($author, $slug_or_id, $channel): string
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to return the latest version for
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return the latest version for
$channel = 'channel_example'; // string | The channel to return the latest version for

try {
    $result = $apiInstance->getLatestVersion($author, $slug_or_id, $channel);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->getLatestVersion: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to return the latest version for | |
| **slug_or_id** | **string**| The slug or id of the project to return the latest version for | |
| **channel** | **string**| The channel to return the latest version for | |

### Return type

**string**

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `text/plain`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getVersion()`

```php
getVersion($author, $slug_or_id, $name_or_id): \Aternos\HangarApi\Model\Version
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to return the version for
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return the version for
$name_or_id = 'name_or_id_example'; // string | The name of the version to return

try {
    $result = $apiInstance->getVersion($author, $slug_or_id, $name_or_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->getVersion: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to return the version for | |
| **slug_or_id** | **string**| The slug or id of the project to return the version for | |
| **name_or_id** | **string**| The name of the version to return | |

### Return type

[**\Aternos\HangarApi\Model\Version**](../Model/Version.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getVersionStats()`

```php
getVersionStats($author, $slug_or_id, $name_or_id, $from_date, $to_date): array<string,\Aternos\HangarApi\Model\VersionStats>
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the version to return the stats for
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return stats for
$name_or_id = 'name_or_id_example'; // string | The name or id of the version to return the stats for
$from_date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | The first date to include in the result
$to_date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | The last date to include in the result

try {
    $result = $apiInstance->getVersionStats($author, $slug_or_id, $name_or_id, $from_date, $to_date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->getVersionStats: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the version to return the stats for | |
| **slug_or_id** | **string**| The slug or id of the project to return stats for | |
| **name_or_id** | **string**| The name or id of the version to return the stats for | |
| **from_date** | **\DateTime**| The first date to include in the result | |
| **to_date** | **\DateTime**| The last date to include in the result | |

### Return type

[**array<string,\Aternos\HangarApi\Model\VersionStats>**](../Model/VersionStats.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getVersions()`

```php
getVersions($author, $slug_or_id, $channel, $platform, $platform_version, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultVersion
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to return versions for
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return versions for
$channel = 'channel_example'; // string | A name of a version channel to filter for
$platform = 'platform_example'; // string | A platform name to filter for
$platform_version = 'platform_version_example'; // string | A platform version to filter for
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->getVersions($author, $slug_or_id, $channel, $platform, $platform_version, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->getVersions: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to return versions for | |
| **slug_or_id** | **string**| The slug or id of the project to return versions for | |
| **channel** | **string**| A name of a version channel to filter for | [optional] |
| **platform** | **string**| A platform name to filter for | [optional] |
| **platform_version** | **string**| A platform version to filter for | [optional] |
| **limit** | **string**| The maximum amount of items to return | [optional] |
| **offset** | **string**| Where to start searching | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PaginatedResultVersion**](../Model/PaginatedResultVersion.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `latestReleaseVersion()`

```php
latestReleaseVersion($slug_or_id): string
```

Returns the latest release version of a project

Returns the latest version of a project. Requires the `view_public_info` permission in the project or owning organizations.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return the latest version for

try {
    $result = $apiInstance->latestReleaseVersion($slug_or_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->latestReleaseVersion: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug_or_id** | **string**| The slug or id of the project to return the latest version for | |

### Return type

**string**

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `text/plain`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `latestVersion()`

```php
latestVersion($slug_or_id, $channel): string
```

Returns the latest version of a project for a specific channel

Returns the latest version of a project. Requires the `view_public_info` permission in the project or owning organization.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return the latest version for
$channel = 'channel_example'; // string | The channel to return the latest version for

try {
    $result = $apiInstance->latestVersion($slug_or_id, $channel);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->latestVersion: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug_or_id** | **string**| The slug or id of the project to return the latest version for | |
| **channel** | **string**| The channel to return the latest version for | |

### Return type

**string**

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `text/plain`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `listVersions()`

```php
listVersions($slug_or_id, $include_hidden_channels, $channel, $platform, $platform_version, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultVersion
```

Returns all versions of a project

Returns all versions of a project. Requires the `view_public_info` permission in the project or owning organization.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return versions for
$include_hidden_channels = true; // bool | Whether to include hidden-by-default channels in the result, defaults to true
$channel = 'channel_example'; // string | A name of a version channel to filter for
$platform = 'platform_example'; // string | A platform name to filter for
$platform_version = 'platform_version_example'; // string | A platform version to filter for
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->listVersions($slug_or_id, $include_hidden_channels, $channel, $platform, $platform_version, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->listVersions: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug_or_id** | **string**| The slug or id of the project to return versions for | |
| **include_hidden_channels** | **bool**| Whether to include hidden-by-default channels in the result, defaults to true | [optional] [default to true] |
| **channel** | **string**| A name of a version channel to filter for | [optional] |
| **platform** | **string**| A platform name to filter for | [optional] |
| **platform_version** | **string**| A platform version to filter for | [optional] |
| **limit** | **string**| The maximum amount of items to return | [optional] |
| **offset** | **string**| Where to start searching | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PaginatedResultVersion**](../Model/PaginatedResultVersion.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `showVersion()`

```php
showVersion($slug_or_id, $name_or_id): \Aternos\HangarApi\Model\Version
```

Returns a specific version of a project

Returns a specific version of a project. Requires the `view_public_info` permission in the project or owning organization.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return the version for
$name_or_id = 'name_or_id_example'; // string | The name or id of the version to return

try {
    $result = $apiInstance->showVersion($slug_or_id, $name_or_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->showVersion: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug_or_id** | **string**| The slug or id of the project to return the version for | |
| **name_or_id** | **string**| The name or id of the version to return | |

### Return type

[**\Aternos\HangarApi\Model\Version**](../Model/Version.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `showVersionById()`

```php
showVersionById($id): \Aternos\HangarApi\Model\Version
```

Returns a specific version by its ID

Returns a specific version by its ID. Requires the `view_public_info` permission in the project or owning organization.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$id = 'id_example'; // string | The id of the version to return

try {
    $result = $apiInstance->showVersionById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->showVersionById: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| The id of the version to return | |

### Return type

[**\Aternos\HangarApi\Model\Version**](../Model/Version.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `showVersionStats()`

```php
showVersionStats($slug_or_id, $name_or_id, $from_date, $to_date): array<string,\Aternos\HangarApi\Model\VersionStats>
```

Returns the stats for a version

Returns the stats (downloads) for a version per day for a certain date range. Requires the `is_subject_member` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return stats for
$name_or_id = 'name_or_id_example'; // string | The version to return the stats for
$from_date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | The first date to include in the result
$to_date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | The last date to include in the result

try {
    $result = $apiInstance->showVersionStats($slug_or_id, $name_or_id, $from_date, $to_date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->showVersionStats: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug_or_id** | **string**| The slug or id of the project to return stats for | |
| **name_or_id** | **string**| The version to return the stats for | |
| **from_date** | **\DateTime**| The first date to include in the result | |
| **to_date** | **\DateTime**| The last date to include in the result | |

### Return type

[**array<string,\Aternos\HangarApi\Model\VersionStats>**](../Model/VersionStats.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `showVersionStatsById()`

```php
showVersionStatsById($id, $from_date, $to_date): array<string,\Aternos\HangarApi\Model\VersionStats>
```

Returns the stats for a version by its ID

Returns the stats (downloads) for a version per day for a certain date range. Requires the `is_subject_member` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$id = 'id_example'; // string | The id of version to return the stats for
$from_date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | The first date to include in the result
$to_date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | The last date to include in the result

try {
    $result = $apiInstance->showVersionStatsById($id, $from_date, $to_date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->showVersionStatsById: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **id** | **string**| The id of version to return the stats for | |
| **from_date** | **\DateTime**| The first date to include in the result | |
| **to_date** | **\DateTime**| The last date to include in the result | |

### Return type

[**array<string,\Aternos\HangarApi\Model\VersionStats>**](../Model/VersionStats.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `uploadVersion()`

```php
uploadVersion($slug_or_id, $version_upload, $files): \Aternos\HangarApi\Model\UploadedVersion
```

Creates a new version and returns parts of its metadata

Creates a new version for a project. Requires the `create_version` permission in the project or owning organization. Make sure you provide the contents of this request as multipart/form-data. You can find a simple example implementation written in Java here: https://gist.github.com/kennytv/a227d82249f54e0ad35005330256fee2

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return versions for
$version_upload = new \Aternos\HangarApi\Model\VersionUpload(); // \Aternos\HangarApi\Model\VersionUpload
$files = array('/path/to/file.txt'); // \SplFileObject[] | The version files in order of selected platforms, if any

try {
    $result = $apiInstance->uploadVersion($slug_or_id, $version_upload, $files);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->uploadVersion: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug_or_id** | **string**| The slug or id of the project to return versions for | |
| **version_upload** | [**\Aternos\HangarApi\Model\VersionUpload**](../Model/VersionUpload.md)|  | |
| **files** | **\SplFileObject[]**| The version files in order of selected platforms, if any | [optional] |

### Return type

[**\Aternos\HangarApi\Model\UploadedVersion**](../Model/UploadedVersion.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: `multipart/form-data`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `uploadVersion1()`

```php
uploadVersion1($author, $slug_or_id, $version_upload, $files): \Aternos\HangarApi\Model\UploadedVersion
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\VersionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to return versions for
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return versions for
$version_upload = new \Aternos\HangarApi\Model\VersionUpload(); // \Aternos\HangarApi\Model\VersionUpload
$files = array('/path/to/file.txt'); // \SplFileObject[] | The version files in order of selected platforms, if any

try {
    $result = $apiInstance->uploadVersion1($author, $slug_or_id, $version_upload, $files);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling VersionsApi->uploadVersion1: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to return versions for | |
| **slug_or_id** | **string**| The slug or id of the project to return versions for | |
| **version_upload** | [**\Aternos\HangarApi\Model\VersionUpload**](../Model/VersionUpload.md)|  | |
| **files** | **\SplFileObject[]**| The version files in order of selected platforms, if any | [optional] |

### Return type

[**\Aternos\HangarApi\Model\UploadedVersion**](../Model/UploadedVersion.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `multipart/form-data`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
