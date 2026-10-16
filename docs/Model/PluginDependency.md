# PluginDependency

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**external_url** | **string** | External url to download the dependency from if not a Hangar project, else null | [optional]
**name** | **string** | Name of the plugin dependency. For non-external dependencies, this should be the Hangar project name | [optional]
**platform** | [**\Aternos\HangarApi\Model\Platform**](Platform.md) | Platform the dependency runs on | [optional]
**project_id** | **int** | Project ID of the dependency. Only for non-external dependencies | [optional]
**required** | **bool** | Whether the dependency is required for the plugin to function | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
