# ApiKey

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**created_at** | **\DateTime** |  | [optional]
**expires_at** | **\DateTime** | The time the key stops working, if it was created with an expiration date | [optional]
**last_used** | **\DateTime** |  | [optional]
**name** | **string** |  | [optional]
**permissions** | [**\Aternos\HangarApi\Model\NamedPermission[]**](NamedPermission.md) |  | [optional]
**project_scoped** | **bool** | Whether the key may only be used on the projects listed below | [optional]
**projects** | [**\Aternos\HangarApi\Model\ProjectNamespace[]**](ProjectNamespace.md) | The projects the key is limited to, empty unless the key is project scoped | [optional]
**token_identifier** | **string** |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
