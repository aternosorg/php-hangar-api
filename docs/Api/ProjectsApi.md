# Aternos\HangarApi\ProjectsApi

All URIs are relative to https://hangar.papermc.io, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getProject()**](ProjectsApi.md#getProject) | **GET** /api/v1/projects/{slugOrId} | Returns info on a specific project |
| [**getProject1()**](ProjectsApi.md#getProject1) | **GET** /api/v1/projects/{author}/{slugOrId} |  |
| [**getProjectMembers()**](ProjectsApi.md#getProjectMembers) | **GET** /api/v1/projects/{slugOrId}/members | Returns the members of a project |
| [**getProjectMembers1()**](ProjectsApi.md#getProjectMembers1) | **GET** /api/v1/projects/{author}/{slugOrId}/members |  |
| [**getProjectStargazers()**](ProjectsApi.md#getProjectStargazers) | **GET** /api/v1/projects/{slugOrId}/stargazers | Returns the stargazers of a project |
| [**getProjectStargazers1()**](ProjectsApi.md#getProjectStargazers1) | **GET** /api/v1/projects/{author}/{slugOrId}/stargazers |  |
| [**getProjectStats()**](ProjectsApi.md#getProjectStats) | **GET** /api/v1/projects/{author}/{slugOrId}/stats |  |
| [**getProjectWatchers()**](ProjectsApi.md#getProjectWatchers) | **GET** /api/v1/projects/{slugOrId}/watchers | Returns the watchers of a project |
| [**getProjectWatchers1()**](ProjectsApi.md#getProjectWatchers1) | **GET** /api/v1/projects/{author}/{slugOrId}/watchers |  |
| [**getProjects()**](ProjectsApi.md#getProjects) | **GET** /api/v1/projects | Searches the projects on Hangar |
| [**projectByVersionHash()**](ProjectsApi.md#projectByVersionHash) | **GET** /api/v1/versions/hash/{hash} | Returns project of the first version that matches the given file hash (SHA-256) |
| [**showProjectStats()**](ProjectsApi.md#showProjectStats) | **GET** /api/v1/projects/{slugOrId}/stats | Returns the stats for a project |


## `getProject()`

```php
getProject($slug_or_id): \Aternos\HangarApi\Model\Project
```

Returns info on a specific project

Returns info on a specific project. Requires the `view_public_info` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug_or_id = 'slug_or_id_example'; // string | The slug or id or id of the project to return

try {
    $result = $apiInstance->getProject($slug_or_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->getProject: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug_or_id** | **string**| The slug or id or id of the project to return | |

### Return type

[**\Aternos\HangarApi\Model\Project**](../Model/Project.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getProject1()`

```php
getProject1($author, $slug_or_id): \Aternos\HangarApi\Model\Project
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to return
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return

try {
    $result = $apiInstance->getProject1($author, $slug_or_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->getProject1: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to return | |
| **slug_or_id** | **string**| The slug or id of the project to return | |

### Return type

[**\Aternos\HangarApi\Model\Project**](../Model/Project.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getProjectMembers()`

```php
getProjectMembers($slug_or_id, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultProjectMember
```

Returns the members of a project

Returns the members of a project. Requires the `view_public_info` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return members for
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->getProjectMembers($slug_or_id, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->getProjectMembers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug_or_id** | **string**| The slug or id of the project to return members for | |
| **limit** | **string**| The maximum amount of items to return | [optional] |
| **offset** | **string**| Where to start searching | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PaginatedResultProjectMember**](../Model/PaginatedResultProjectMember.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getProjectMembers1()`

```php
getProjectMembers1($author, $slug_or_id, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultProjectMember
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to return members for
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return members for
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->getProjectMembers1($author, $slug_or_id, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->getProjectMembers1: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to return members for | |
| **slug_or_id** | **string**| The slug or id of the project to return members for | |
| **limit** | **string**| The maximum amount of items to return | [optional] |
| **offset** | **string**| Where to start searching | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PaginatedResultProjectMember**](../Model/PaginatedResultProjectMember.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getProjectStargazers()`

```php
getProjectStargazers($slug_or_id, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultUser
```

Returns the stargazers of a project

Returns the stargazers of a project. Requires the `view_public_info` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return stargazers for
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->getProjectStargazers($slug_or_id, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->getProjectStargazers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug_or_id** | **string**| The slug or id of the project to return stargazers for | |
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

## `getProjectStargazers1()`

```php
getProjectStargazers1($author, $slug_or_id, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultUser
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to return stargazers for
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return stargazers for
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->getProjectStargazers1($author, $slug_or_id, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->getProjectStargazers1: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to return stargazers for | |
| **slug_or_id** | **string**| The slug or id of the project to return stargazers for | |
| **limit** | **string**| The maximum amount of items to return | [optional] |
| **offset** | **string**| Where to start searching | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PaginatedResultUser**](../Model/PaginatedResultUser.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getProjectStats()`

```php
getProjectStats($author, $slug_or_id, $from_date, $to_date): array<string,\Aternos\HangarApi\Model\DayProjectStats>
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to return stats for
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return stats for
$from_date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | The first date to include in the result
$to_date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | The last date to include in the result

try {
    $result = $apiInstance->getProjectStats($author, $slug_or_id, $from_date, $to_date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->getProjectStats: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to return stats for | |
| **slug_or_id** | **string**| The slug or id of the project to return stats for | |
| **from_date** | **\DateTime**| The first date to include in the result | |
| **to_date** | **\DateTime**| The last date to include in the result | |

### Return type

[**array<string,\Aternos\HangarApi\Model\DayProjectStats>**](../Model/DayProjectStats.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getProjectWatchers()`

```php
getProjectWatchers($slug_or_id, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultUser
```

Returns the watchers of a project

Returns the watchers of a project. Requires the `view_public_info` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return watchers for
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->getProjectWatchers($slug_or_id, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->getProjectWatchers: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug_or_id** | **string**| The slug or id of the project to return watchers for | |
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

## `getProjectWatchers1()`

```php
getProjectWatchers1($author, $slug_or_id, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultUser
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to return watchers for
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return watchers for
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->getProjectWatchers1($author, $slug_or_id, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->getProjectWatchers1: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to return watchers for | |
| **slug_or_id** | **string**| The slug or id of the project to return watchers for | |
| **limit** | **string**| The maximum amount of items to return | [optional] |
| **offset** | **string**| Where to start searching | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PaginatedResultUser**](../Model/PaginatedResultUser.md)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getProjects()`

```php
getProjects($prioritize_exact_match, $sort, $category, $platform, $owner, $q, $query, $license, $version, $tag, $member, $limit, $offset): \Aternos\HangarApi\Model\PaginatedResultProject
```

Searches the projects on Hangar

Searches all the projects on Hangar, or for a single user. Requires the `view_public_info` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$prioritize_exact_match = true; // bool | Whether to prioritize the project with an exact name match if present
$sort = 'sort_example'; // string | Used to sort the result
$category = 'category_example'; // string | A category to filter for
$platform = 'platform_example'; // string | A platform to filter for
$owner = 'owner_example'; // string | The author of the project
$q = 'q_example'; // string | Deprecated: Use 'query' instead
$query = 'query_example'; // string | The query to use when searching
$license = 'license_example'; // string | A license to filter for
$version = 'version_example'; // string | A platform version to filter for
$tag = 'tag_example'; // string | A tag to filter for
$member = 'member_example'; // string | The member of the project
$limit = 1; // string | The maximum amount of items to return
$offset = 0; // string | Where to start searching

try {
    $result = $apiInstance->getProjects($prioritize_exact_match, $sort, $category, $platform, $owner, $q, $query, $license, $version, $tag, $member, $limit, $offset);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->getProjects: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **prioritize_exact_match** | **bool**| Whether to prioritize the project with an exact name match if present | [optional] [default to true] |
| **sort** | **string**| Used to sort the result | [optional] |
| **category** | **string**| A category to filter for | [optional] |
| **platform** | **string**| A platform to filter for | [optional] |
| **owner** | **string**| The author of the project | [optional] |
| **q** | **string**| Deprecated: Use &#39;query&#39; instead | [optional] |
| **query** | **string**| The query to use when searching | [optional] |
| **license** | **string**| A license to filter for | [optional] |
| **version** | **string**| A platform version to filter for | [optional] |
| **tag** | **string**| A tag to filter for | [optional] |
| **member** | **string**| The member of the project | [optional] |
| **limit** | **string**| The maximum amount of items to return | [optional] |
| **offset** | **string**| Where to start searching | [optional] |

### Return type

[**\Aternos\HangarApi\Model\PaginatedResultProject**](../Model/PaginatedResultProject.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `projectByVersionHash()`

```php
projectByVersionHash($hash): \Aternos\HangarApi\Model\Project
```

Returns project of the first version that matches the given file hash (SHA-256)

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$hash = 'hash_example'; // string | The SHA-256 hash of the version

try {
    $result = $apiInstance->projectByVersionHash($hash);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->projectByVersionHash: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **hash** | **string**| The SHA-256 hash of the version | |

### Return type

[**\Aternos\HangarApi\Model\Project**](../Model/Project.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `showProjectStats()`

```php
showProjectStats($slug_or_id, $from_date, $to_date): array<string,\Aternos\HangarApi\Model\DayProjectStats>
```

Returns the stats for a project

Returns the stats (downloads and views) for a project per day for a certain date range. Requires the `is_subject_member` permission.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\ProjectsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$slug_or_id = 'slug_or_id_example'; // string | The slug or id of the project to return stats for
$from_date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | The first date to include in the result
$to_date = new \DateTime('2013-10-20T19:20:30+01:00'); // \DateTime | The last date to include in the result

try {
    $result = $apiInstance->showProjectStats($slug_or_id, $from_date, $to_date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProjectsApi->showProjectStats: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **slug_or_id** | **string**| The slug or id of the project to return stats for | |
| **from_date** | **\DateTime**| The first date to include in the result | |
| **to_date** | **\DateTime**| The last date to include in the result | |

### Return type

[**array<string,\Aternos\HangarApi\Model\DayProjectStats>**](../Model/DayProjectStats.md)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
