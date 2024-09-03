<?php
/**
 * Platform
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
 * Generator version: 7.8.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Aternos\HangarApi\Model;
use \Aternos\HangarApi\ObjectSerializer;

/**
 * Platform Class Doc Comment
 *
 * @category Class
 * @description Server platform
 * @package  Aternos\HangarApi
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class Platform
{
    /**
     * Possible values of this enum
     */
    public const PAPER = 'PAPER';

    public const WATERFALL = 'WATERFALL';

    public const VELOCITY = 'VELOCITY';

    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::PAPER,
            self::WATERFALL,
            self::VELOCITY
        ];
    }
}


