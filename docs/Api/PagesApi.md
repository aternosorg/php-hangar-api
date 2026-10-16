# Aternos\HangarApi\PagesApi

All URIs are relative to https://hangar.papermc.io, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**editMainPage()**](PagesApi.md#editMainPage) | **PATCH** /api/v1/pages/editmain/{project} | Edits the main page of a project |
| [**editMainPage1()**](PagesApi.md#editMainPage1) | **PATCH** /api/v1/pages/editmain/{author}/{project} |  |
| [**editPage()**](PagesApi.md#editPage) | **PATCH** /api/v1/pages/edit/{project} | Edits a page of a project |
| [**editPage1()**](PagesApi.md#editPage1) | **PATCH** /api/v1/pages/edit/{author}/{project} |  |
| [**getMainPage()**](PagesApi.md#getMainPage) | **GET** /api/v1/pages/main/{project} | Returns the main page of a project |
| [**getMainPage1()**](PagesApi.md#getMainPage1) | **GET** /api/v1/pages/main/{author}/{project} |  |
| [**getPage()**](PagesApi.md#getPage) | **GET** /api/v1/pages/page/{project} | Returns a page of a project |
| [**getPage1()**](PagesApi.md#getPage1) | **GET** /api/v1/pages/page/{author}/{project} |  |


## `editMainPage()`

```php
editMainPage($project, $string_content)
```

Edits the main page of a project

Edits the main page of a project. Requires the `edit_page` permission in the project or owning organization.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\PagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 'project_example'; // string | The slug or id of the project to change the page for
$string_content = new \Aternos\HangarApi\Model\StringContent(); // \Aternos\HangarApi\Model\StringContent

try {
    $apiInstance->editMainPage($project, $string_content);
} catch (Exception $e) {
    echo 'Exception when calling PagesApi->editMainPage: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| The slug or id of the project to change the page for | |
| **string_content** | [**\Aternos\HangarApi\Model\StringContent**](../Model/StringContent.md)|  | |

### Return type

void (empty response body)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `editMainPage1()`

```php
editMainPage1($author, $project, $string_content)
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\PagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to change the page for
$project = 'project_example'; // string | The slug or id of the project to change the page for
$string_content = new \Aternos\HangarApi\Model\StringContent(); // \Aternos\HangarApi\Model\StringContent

try {
    $apiInstance->editMainPage1($author, $project, $string_content);
} catch (Exception $e) {
    echo 'Exception when calling PagesApi->editMainPage1: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to change the page for | |
| **project** | **string**| The slug or id of the project to change the page for | |
| **string_content** | [**\Aternos\HangarApi\Model\StringContent**](../Model/StringContent.md)|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `editPage()`

```php
editPage($project, $page_edit_form)
```

Edits a page of a project

Edits a page of a project. Requires the `edit_page` permission in the project or owning organization.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure Bearer (JWT) authorization: HangarAuth
$config = Aternos\HangarApi\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Aternos\HangarApi\Api\PagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$project = 'project_example'; // string | The slug or id of the project to change the page for
$page_edit_form = new \Aternos\HangarApi\Model\PageEditForm(); // \Aternos\HangarApi\Model\PageEditForm

try {
    $apiInstance->editPage($project, $page_edit_form);
} catch (Exception $e) {
    echo 'Exception when calling PagesApi->editPage: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| The slug or id of the project to change the page for | |
| **page_edit_form** | [**\Aternos\HangarApi\Model\PageEditForm**](../Model/PageEditForm.md)|  | |

### Return type

void (empty response body)

### Authorization

[HangarAuth](../../README.md#HangarAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `editPage1()`

```php
editPage1($author, $project, $page_edit_form)
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\PagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to change the page for
$project = 'project_example'; // string | The slug or id of the project to change the page for
$page_edit_form = new \Aternos\HangarApi\Model\PageEditForm(); // \Aternos\HangarApi\Model\PageEditForm

try {
    $apiInstance->editPage1($author, $project, $page_edit_form);
} catch (Exception $e) {
    echo 'Exception when calling PagesApi->editPage1: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to change the page for | |
| **project** | **string**| The slug or id of the project to change the page for | |
| **page_edit_form** | [**\Aternos\HangarApi\Model\PageEditForm**](../Model/PageEditForm.md)|  | |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getMainPage()`

```php
getMainPage($project): string
```

Returns the main page of a project

Returns the main page of a project. Requires visibility of the page.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\PagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$project = 'project_example'; // string | The slug or id of the project to return the page for

try {
    $result = $apiInstance->getMainPage($project);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PagesApi->getMainPage: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| The slug or id of the project to return the page for | |

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

## `getMainPage1()`

```php
getMainPage1($author, $project): string
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\PagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to return the page for
$project = 'project_example'; // string | The slug or id of the project to return the page for

try {
    $result = $apiInstance->getMainPage1($author, $project);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PagesApi->getMainPage1: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to return the page for | |
| **project** | **string**| The slug or id of the project to return the page for | |

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

## `getPage()`

```php
getPage($project, $path): string
```

Returns a page of a project

Returns a page of a project. Requires visibility of the page.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\PagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$project = 'project_example'; // string | The slug or id of the project to return the page for
$path = 'path_example'; // string | The path of the page

try {
    $result = $apiInstance->getPage($project, $path);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PagesApi->getPage: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **project** | **string**| The slug or id of the project to return the page for | |
| **path** | **string**| The path of the page | |

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

## `getPage1()`

```php
getPage1($author, $project, $path): string
```



### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



$apiInstance = new Aternos\HangarApi\Api\PagesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$author = 'author_example'; // string | The author of the project to return the page for
$project = 'project_example'; // string | The slug or id of the project to return the page for
$path = 'path_example'; // string | The path of the page

try {
    $result = $apiInstance->getPage1($author, $project, $path);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling PagesApi->getPage1: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **author** | **string**| The author of the project to return the page for | |
| **project** | **string**| The slug or id of the project to return the page for | |
| **path** | **string**| The path of the page | |

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
