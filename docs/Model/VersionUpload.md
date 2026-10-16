# VersionUpload

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**channel** | **string** | Channel of the version to be published under |
**description** | **string** |  | [optional]
**files** | [**\Aternos\HangarApi\Model\MultipartFileOrUrl[]**](MultipartFileOrUrl.md) |  |
**platform_dependencies** | [**array<string,string[]>**](Set.md) | Map of platforms and their versions this version runs on |
**plugin_dependencies** | [**array<string,\Aternos\HangarApi\Model\PluginDependency[]>**](Set.md) | Map of each platform&#39;s plugin dependencies | [optional]
**version** | **string** | Version string of the version to be published |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
