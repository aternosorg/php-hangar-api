<?php
/**
 * UsersApiTest
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
 * OpenAPI Generator version: 6.6.0-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Please update the test case below to test the endpoint.
 */

namespace Aternos\HangarApi\Test\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\Options\ProjectCategory;
use Aternos\HangarApi\Model\Category;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    protected ?HangarAPIClient $apiClient = null;

    /**
     * Setup before running any test cases
     */
    public static function setUpBeforeClass(): void
    {
    }

    /**
     * Setup before running each test case
     */
    public function setUp(): void
    {
        $this->apiClient = new HangarAPIClient();
        $this->apiClient->setUserAgent("aternos/php-hangar-api@1.0.0 (contact@aternos.org)");
        $this->apiClient->setApiKey(getenv("HANGAR_API_KEY"));
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown(): void
    {
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass(): void
    {
    }

    protected function assertValidNamespace($namespace): void
    {
        $this->assertNotNull($namespace);
        $this->assertInstanceOf(\Aternos\HangarApi\Model\ProjectNamespace::class, $namespace);
        $this->assertNotNull($namespace->getOwner());
        $this->assertNotNull($namespace->getSlug());
    }

    protected function assertValidProject($project): void
    {
        $this->assertNotNull($project);
        $this->assertNotNull($project->getData());
        $this->assertValidNamespace($project->getData()->getNamespace());
        $this->assertNotNull($project->getData()->getName());
        $this->assertNotNull($project->getData()->getStats());
        $this->assertNotNull($project->getData()->getStats()->getViews());
        $this->assertNotNull($project->getData()->getStats()->getDownloads());
        $this->assertNotNull($project->getData()->getStats()->getRecentViews());
        $this->assertNotNull($project->getData()->getStats()->getRecentDownloads());
        $this->assertNotNull($project->getData()->getStats()->getStars());
        $this->assertNotNull($project->getData()->getStats()->getWatchers());
        $this->assertNotNull($project->getData()->getCategory());
        $this->assertNotNull(ProjectCategory::from($project->getData()->getCategory()));
        $this->assertNotNull($project->getData()->getLastUpdated());
        $this->assertNotNull($project->getData()->getVisibility());
        $this->assertNotNull($project->getData()->getDescription());
        $this->assertNotNull($project->getData()->getUserActions());
        $this->assertNotNull($project->getData()->getSettings());
    }


    /**
     * Test case for getProjects
     * @throws ApiException
     */
    public function testGetProjects()
    {
        $projectList = $this->apiClient->getProjects();
        $this->assertFalse($projectList->hasPreviousPage());

        $firstProjectOfPages = [];
        for ($i = 0; $i < 3; $i++) {
            $this->assertNotNull($projectList);
            $this->assertNotNull($projectList->getResults());
            $this->assertNotEmpty($projectList->getResults());
            $firstProjectOfPages[$i] = $projectList->getResults()[0];

            foreach ($projectList->getResults() as $project) {
                $this->assertValidProject($project);
            }

            $this->assertTrue($projectList->hasNextPage());
            $projectList = $projectList->getNextPage();
        }

        for ($i = 2; $i >= 0; $i--) {
            $this->assertTrue($projectList->hasPreviousPage());
            $projectList = $projectList->getPreviousPage();

            $this->assertNotNull($projectList);
            $this->assertNotNull($projectList->getResults());
            $this->assertNotEmpty($projectList->getResults());
            $this->assertEquals($firstProjectOfPages[$i], $projectList->getResults()[0]);
            $firstProjectOfPages[$i] = $projectList->getResults()[0];

            foreach ($projectList->getResults() as $project) {
                $this->assertValidProject($project);
            }
            $this->assertTrue($projectList->hasNextPage());
        }
        $this->assertFalse($projectList->hasPreviousPage());
    }
}
