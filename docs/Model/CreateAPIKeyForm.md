# CreateAPIKeyForm

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**expires_at** | **\DateTime** | Point in time at which the key stops working. Leave empty for a key that never expires | [optional]
**name** | **string** |  |
**permissions** | [**\Aternos\HangarApi\Model\NamedPermission[]**](NamedPermission.md) |  |
**projects** | **string[]** | Slugs of the projects the key may be used on. Leave empty to allow all projects | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
