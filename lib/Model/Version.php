<?php
/**
 * Version
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
 * OpenAPI Generator version: 6.5.0-SNAPSHOT
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
 * Version Class Doc Comment
 *
 * @category Class
 * @package  Aternos\HangarApi
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class Version implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'Version';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'created_at' => '\DateTime',
        'name' => 'string',
        'visibility' => '\Aternos\HangarApi\Model\Visibility',
        'description' => 'string',
        'stats' => '\Aternos\HangarApi\Model\VersionStats',
        'author' => 'string',
        'review_state' => '\Aternos\HangarApi\Model\ReviewState',
        'channel' => '\Aternos\HangarApi\Model\ProjectChannel',
        'pinned_status' => '\Aternos\HangarApi\Model\PinnedStatus',
        'downloads' => 'array<string,\Aternos\HangarApi\Model\PlatformVersionDownload>',
        'plugin_dependencies' => 'array<string,\Aternos\HangarApi\Model\PluginDependency[]>',
        'platform_dependencies' => 'array<string,string[]>',
        'platform_dependencies_formatted' => 'array<string,string>'
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
        'visibility' => null,
        'description' => null,
        'stats' => null,
        'author' => null,
        'review_state' => null,
        'channel' => null,
        'pinned_status' => null,
        'downloads' => null,
        'plugin_dependencies' => null,
        'platform_dependencies' => null,
        'platform_dependencies_formatted' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'created_at' => false,
		'name' => false,
		'visibility' => false,
		'description' => false,
		'stats' => false,
		'author' => false,
		'review_state' => false,
		'channel' => false,
		'pinned_status' => false,
		'downloads' => false,
		'plugin_dependencies' => false,
		'platform_dependencies' => false,
		'platform_dependencies_formatted' => false
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
        'visibility' => 'visibility',
        'description' => 'description',
        'stats' => 'stats',
        'author' => 'author',
        'review_state' => 'reviewState',
        'channel' => 'channel',
        'pinned_status' => 'pinnedStatus',
        'downloads' => 'downloads',
        'plugin_dependencies' => 'pluginDependencies',
        'platform_dependencies' => 'platformDependencies',
        'platform_dependencies_formatted' => 'platformDependenciesFormatted'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'created_at' => 'setCreatedAt',
        'name' => 'setName',
        'visibility' => 'setVisibility',
        'description' => 'setDescription',
        'stats' => 'setStats',
        'author' => 'setAuthor',
        'review_state' => 'setReviewState',
        'channel' => 'setChannel',
        'pinned_status' => 'setPinnedStatus',
        'downloads' => 'setDownloads',
        'plugin_dependencies' => 'setPluginDependencies',
        'platform_dependencies' => 'setPlatformDependencies',
        'platform_dependencies_formatted' => 'setPlatformDependenciesFormatted'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'created_at' => 'getCreatedAt',
        'name' => 'getName',
        'visibility' => 'getVisibility',
        'description' => 'getDescription',
        'stats' => 'getStats',
        'author' => 'getAuthor',
        'review_state' => 'getReviewState',
        'channel' => 'getChannel',
        'pinned_status' => 'getPinnedStatus',
        'downloads' => 'getDownloads',
        'plugin_dependencies' => 'getPluginDependencies',
        'platform_dependencies' => 'getPlatformDependencies',
        'platform_dependencies_formatted' => 'getPlatformDependenciesFormatted'
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
        $this->setIfExists('visibility', $data ?? [], null);
        $this->setIfExists('description', $data ?? [], null);
        $this->setIfExists('stats', $data ?? [], null);
        $this->setIfExists('author', $data ?? [], null);
        $this->setIfExists('review_state', $data ?? [], null);
        $this->setIfExists('channel', $data ?? [], null);
        $this->setIfExists('pinned_status', $data ?? [], null);
        $this->setIfExists('downloads', $data ?? [], null);
        $this->setIfExists('plugin_dependencies', $data ?? [], null);
        $this->setIfExists('platform_dependencies', $data ?? [], null);
        $this->setIfExists('platform_dependencies_formatted', $data ?? [], null);
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
     * Gets visibility
     *
     * @return \Aternos\HangarApi\Model\Visibility|null
     */
    public function getVisibility()
    {
        return $this->container['visibility'];
    }

    /**
     * Sets visibility
     *
     * @param \Aternos\HangarApi\Model\Visibility|null $visibility visibility
     *
     * @return self
     */
    public function setVisibility($visibility)
    {
        if (is_null($visibility)) {
            throw new \InvalidArgumentException('non-nullable visibility cannot be null');
        }
        $this->container['visibility'] = $visibility;

        return $this;
    }

    /**
     * Gets description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     *
     * @param string|null $description description
     *
     * @return self
     */
    public function setDescription($description)
    {
        if (is_null($description)) {
            throw new \InvalidArgumentException('non-nullable description cannot be null');
        }
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets stats
     *
     * @return \Aternos\HangarApi\Model\VersionStats|null
     */
    public function getStats()
    {
        return $this->container['stats'];
    }

    /**
     * Sets stats
     *
     * @param \Aternos\HangarApi\Model\VersionStats|null $stats stats
     *
     * @return self
     */
    public function setStats($stats)
    {
        if (is_null($stats)) {
            throw new \InvalidArgumentException('non-nullable stats cannot be null');
        }
        $this->container['stats'] = $stats;

        return $this;
    }

    /**
     * Gets author
     *
     * @return string|null
     */
    public function getAuthor()
    {
        return $this->container['author'];
    }

    /**
     * Sets author
     *
     * @param string|null $author author
     *
     * @return self
     */
    public function setAuthor($author)
    {
        if (is_null($author)) {
            throw new \InvalidArgumentException('non-nullable author cannot be null');
        }
        $this->container['author'] = $author;

        return $this;
    }

    /**
     * Gets review_state
     *
     * @return \Aternos\HangarApi\Model\ReviewState|null
     */
    public function getReviewState()
    {
        return $this->container['review_state'];
    }

    /**
     * Sets review_state
     *
     * @param \Aternos\HangarApi\Model\ReviewState|null $review_state review_state
     *
     * @return self
     */
    public function setReviewState($review_state)
    {
        if (is_null($review_state)) {
            throw new \InvalidArgumentException('non-nullable review_state cannot be null');
        }
        $this->container['review_state'] = $review_state;

        return $this;
    }

    /**
     * Gets channel
     *
     * @return \Aternos\HangarApi\Model\ProjectChannel|null
     */
    public function getChannel()
    {
        return $this->container['channel'];
    }

    /**
     * Sets channel
     *
     * @param \Aternos\HangarApi\Model\ProjectChannel|null $channel channel
     *
     * @return self
     */
    public function setChannel($channel)
    {
        if (is_null($channel)) {
            throw new \InvalidArgumentException('non-nullable channel cannot be null');
        }
        $this->container['channel'] = $channel;

        return $this;
    }

    /**
     * Gets pinned_status
     *
     * @return \Aternos\HangarApi\Model\PinnedStatus|null
     */
    public function getPinnedStatus()
    {
        return $this->container['pinned_status'];
    }

    /**
     * Sets pinned_status
     *
     * @param \Aternos\HangarApi\Model\PinnedStatus|null $pinned_status pinned_status
     *
     * @return self
     */
    public function setPinnedStatus($pinned_status)
    {
        if (is_null($pinned_status)) {
            throw new \InvalidArgumentException('non-nullable pinned_status cannot be null');
        }
        $this->container['pinned_status'] = $pinned_status;

        return $this;
    }

    /**
     * Gets downloads
     *
     * @return array<string,\Aternos\HangarApi\Model\PlatformVersionDownload>|null
     */
    public function getDownloads()
    {
        return $this->container['downloads'];
    }

    /**
     * Sets downloads
     *
     * @param array<string,\Aternos\HangarApi\Model\PlatformVersionDownload>|null $downloads downloads
     *
     * @return self
     */
    public function setDownloads($downloads)
    {
        if (is_null($downloads)) {
            throw new \InvalidArgumentException('non-nullable downloads cannot be null');
        }
        $this->container['downloads'] = $downloads;

        return $this;
    }

    /**
     * Gets plugin_dependencies
     *
     * @return array<string,\Aternos\HangarApi\Model\PluginDependency[]>|null
     */
    public function getPluginDependencies()
    {
        return $this->container['plugin_dependencies'];
    }

    /**
     * Sets plugin_dependencies
     *
     * @param array<string,\Aternos\HangarApi\Model\PluginDependency[]>|null $plugin_dependencies plugin_dependencies
     *
     * @return self
     */
    public function setPluginDependencies($plugin_dependencies)
    {
        if (is_null($plugin_dependencies)) {
            throw new \InvalidArgumentException('non-nullable plugin_dependencies cannot be null');
        }
        $this->container['plugin_dependencies'] = $plugin_dependencies;

        return $this;
    }

    /**
     * Gets platform_dependencies
     *
     * @return array<string,string[]>|null
     */
    public function getPlatformDependencies()
    {
        return $this->container['platform_dependencies'];
    }

    /**
     * Sets platform_dependencies
     *
     * @param array<string,string[]>|null $platform_dependencies platform_dependencies
     *
     * @return self
     */
    public function setPlatformDependencies($platform_dependencies)
    {
        if (is_null($platform_dependencies)) {
            throw new \InvalidArgumentException('non-nullable platform_dependencies cannot be null');
        }
        $this->container['platform_dependencies'] = $platform_dependencies;

        return $this;
    }

    /**
     * Gets platform_dependencies_formatted
     *
     * @return array<string,string>|null
     */
    public function getPlatformDependenciesFormatted()
    {
        return $this->container['platform_dependencies_formatted'];
    }

    /**
     * Sets platform_dependencies_formatted
     *
     * @param array<string,string>|null $platform_dependencies_formatted platform_dependencies_formatted
     *
     * @return self
     */
    public function setPlatformDependenciesFormatted($platform_dependencies_formatted)
    {
        if (is_null($platform_dependencies_formatted)) {
            throw new \InvalidArgumentException('non-nullable platform_dependencies_formatted cannot be null');
        }
        $this->container['platform_dependencies_formatted'] = $platform_dependencies_formatted;

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


