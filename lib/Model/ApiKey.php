<?php
/**
 * ApiKey
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  Aternos\HangarApi
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Hangar API
 *
 * This page describes the format for the current Hangar REST API as well as general usage guidelines.<br> Note that all routes **not** listed here should be considered **internal**, and can change at a moment's notice. **Do not use them**.  ## Authentication and Authorization There are two ways to consume the API: Authenticated or anonymous.  ### Anonymous When using anonymous authentication, you only have access to public information, but you don't need to worry about creating and storing an API key or handing JWTs.  ### Authenticated If you need access to non-public content or actions, you need to create and use API keys. These can be created by going to the API keys page via the profile dropdown or by going to your user page and clicking on the key icon.  API keys allow you to impersonate yourself, so they should be handled like passwords. **Do not share them with anyone else!**  #### Getting and Using a JWT Once you have an API key, you need to authenticate yourself: Send a `POST` request with your API key identifier to `/api/v1/authenticate?apiKey=yourKey`. The response will contain your JWT as well as an expiration time. Put this JWT into the `Authorization` header of every request and make sure to request a new JWT after the expiration time has passed.  Please also set a meaningful `User-Agent` header. This allows us to better identify loads and needs for potentially new endpoints.  ## Misc ### Date Formats Standard ISO types. Where possible, we use the [OpenAPI format modifier](https://swagger.io/docs/specification/data-models/data-types/#format).  ### Rate Limits and Caching The default rate limit is set at 20 requests every 5 seconds with an initial overdraft for extra leniency. Individual endpoints, such as version creation, may have stricter rate limiting.  If applicable, always cache responses. The Hangar API itself is cached by CloudFlare and internally.
 *
 * The version of the OpenAPI document: 1.0
 * Generated by: https://openapi-generator.tech
 * Generator version: 7.7.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Aternos\HangarApi\Model;

use \ArrayAccess;
use \Aternos\HangarApi\ObjectSerializer;

/**
 * ApiKey Class Doc Comment
 *
 * @category Class
 * @package  Aternos\HangarApi
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class ApiKey implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'ApiKey';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'created_at' => '\DateTime',
        'name' => 'string',
        'token_identifier' => 'string',
        'permissions' => '\Aternos\HangarApi\Model\NamedPermission[]',
        'last_used' => '\DateTime'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'created_at' => 'date-time',
        'name' => null,
        'token_identifier' => null,
        'permissions' => null,
        'last_used' => 'date-time'
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'created_at' => false,
        'name' => false,
        'token_identifier' => false,
        'permissions' => false,
        'last_used' => false
    ];

    /**
      * If a nullable field gets set to null, insert it here
      *
      * @var boolean[]
      */
    protected array $openAPINullablesSetToNull = [];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of nullable properties
     *
     * @return array
     */
    protected static function openAPINullables(): array
    {
        return self::$openAPINullables;
    }

    /**
     * Array of nullable field names deliberately set to null
     *
     * @return boolean[]
     */
    private function getOpenAPINullablesSetToNull(): array
    {
        return $this->openAPINullablesSetToNull;
    }

    /**
     * Setter - Array of nullable field names deliberately set to null
     *
     * @param boolean[] $openAPINullablesSetToNull
     */
    private function setOpenAPINullablesSetToNull(array $openAPINullablesSetToNull): void
    {
        $this->openAPINullablesSetToNull = $openAPINullablesSetToNull;
    }

    /**
     * Checks if a property is nullable
     *
     * @param string $property
     * @return bool
     */
    public static function isNullable(string $property): bool
    {
        return self::openAPINullables()[$property] ?? false;
    }

    /**
     * Checks if a nullable property is set to null.
     *
     * @param string $property
     * @return bool
     */
    public function isNullableSetToNull(string $property): bool
    {
        return in_array($property, $this->getOpenAPINullablesSetToNull(), true);
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'created_at' => 'createdAt',
        'name' => 'name',
        'token_identifier' => 'tokenIdentifier',
        'permissions' => 'permissions',
        'last_used' => 'lastUsed'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'created_at' => 'setCreatedAt',
        'name' => 'setName',
        'token_identifier' => 'setTokenIdentifier',
        'permissions' => 'setPermissions',
        'last_used' => 'setLastUsed'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'created_at' => 'getCreatedAt',
        'name' => 'getName',
        'token_identifier' => 'getTokenIdentifier',
        'permissions' => 'getPermissions',
        'last_used' => 'getLastUsed'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }


    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->setIfExists('created_at', $data ?? [], null);
        $this->setIfExists('name', $data ?? [], null);
        $this->setIfExists('token_identifier', $data ?? [], null);
        $this->setIfExists('permissions', $data ?? [], null);
        $this->setIfExists('last_used', $data ?? [], null);
    }

    /**
    * Sets $this->container[$variableName] to the given data or to the given default Value; if $variableName
    * is nullable and its value is set to null in the $fields array, then mark it as "set to null" in the
    * $this->openAPINullablesSetToNull array
    *
    * @param string $variableName
    * @param array  $fields
    * @param mixed  $defaultValue
    */
    private function setIfExists(string $variableName, array $fields, $defaultValue): void
    {
        if (self::isNullable($variableName) && array_key_exists($variableName, $fields) && is_null($fields[$variableName])) {
            $this->openAPINullablesSetToNull[] = $variableName;
        }

        $this->container[$variableName] = $fields[$variableName] ?? $defaultValue;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets created_at
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->container['created_at'];
    }

    /**
     * Sets created_at
     *
     * @param \DateTime|null $created_at created_at
     *
     * @return self
     */
    public function setCreatedAt($created_at)
    {
        if (is_null($created_at)) {
            throw new \InvalidArgumentException('non-nullable created_at cannot be null');
        }
        $this->container['created_at'] = $created_at;

        return $this;
    }

    /**
     * Gets name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string|null $name name
     *
     * @return self
     */
    public function setName($name)
    {
        if (is_null($name)) {
            throw new \InvalidArgumentException('non-nullable name cannot be null');
        }
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets token_identifier
     *
     * @return string|null
     */
    public function getTokenIdentifier()
    {
        return $this->container['token_identifier'];
    }

    /**
     * Sets token_identifier
     *
     * @param string|null $token_identifier token_identifier
     *
     * @return self
     */
    public function setTokenIdentifier($token_identifier)
    {
        if (is_null($token_identifier)) {
            throw new \InvalidArgumentException('non-nullable token_identifier cannot be null');
        }
        $this->container['token_identifier'] = $token_identifier;

        return $this;
    }

    /**
     * Gets permissions
     *
     * @return \Aternos\HangarApi\Model\NamedPermission[]|null
     */
    public function getPermissions()
    {
        return $this->container['permissions'];
    }

    /**
     * Sets permissions
     *
     * @param \Aternos\HangarApi\Model\NamedPermission[]|null $permissions permissions
     *
     * @return self
     */
    public function setPermissions($permissions)
    {
        if (is_null($permissions)) {
            throw new \InvalidArgumentException('non-nullable permissions cannot be null');
        }
        $this->container['permissions'] = $permissions;

        return $this;
    }

    /**
     * Gets last_used
     *
     * @return \DateTime|null
     */
    public function getLastUsed()
    {
        return $this->container['last_used'];
    }

    /**
     * Sets last_used
     *
     * @param \DateTime|null $last_used last_used
     *
     * @return self
     */
    public function setLastUsed($last_used)
    {
        if (is_null($last_used)) {
            throw new \InvalidArgumentException('non-nullable last_used cannot be null');
        }
        $this->container['last_used'] = $last_used;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed|null
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int|null $offset Offset
     * @param mixed    $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value
     * of any type other than a resource.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
       return ObjectSerializer::sanitizeForSerialization($this);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


