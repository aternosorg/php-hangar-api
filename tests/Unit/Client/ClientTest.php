<?php

namespace Aternos\HangarApi\Tests\Unit\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\Options\ProjectCategory;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
use Aternos\HangarApi\Client\Options\VersionSearch\VersionSearchOptions;
use Aternos\HangarApi\Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class ClientTest extends TestCase
{

    /**
     * @throws ApiException
     */
    public function testListProjects(): void
    {
        $handler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjects.json")),
        ]);
        $this->apiClient->setHttpClient(new Client(['handler' => HandlerStack::create($handler)]));

        $projectList = $this->apiClient->getProjects();

        foreach ($projectList as $project) {
            $this->assertValidProject($project->getData());
        }
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectsWithSearchOptions(): void
    {
        $handler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjectsInCategory.json")),
        ]);
        $this->apiClient->setHttpClient(new Client(['handler' => HandlerStack::create($handler)]));

        $searchOptions = (new ProjectSearchOptions())->setCategory(ProjectCategory::CHAT);
        $projectList = $this->apiClient->getProjects($searchOptions);

        foreach ($projectList as $project) {
            $this->assertValidProject($project->getData());
            $this->assertEquals(ProjectCategory::CHAT->value, $project->getData()->getCategory());
        }
    }

    /**
     * @throws ApiException
     */
    public function testGetProject(): void
    {
        $handler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
        ]);
        $this->apiClient->setHttpClient(new Client(['handler' => HandlerStack::create($handler)]));

        $project = $this->apiClient->getProject("ViaVersion");
        $this->assertNotNull($project);
        $this->assertValidProject($project->getData());
        $this->assertEquals("ViaVersion", $project->getData()->getName());
    }

    /**
     * @throws ApiException
     */
    public function testGetVersion(): void
    {
        $handler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getVersion.json")),
        ]);
        $this->apiClient->setHttpClient(new Client(['handler' => HandlerStack::create($handler)]));

        $version = $this->apiClient->getVersion("ViaVersion", "5.0.0");
        $this->assertNotNull($version);
        $this->assertValidVersion($version->getData());
        $this->assertEquals("5.0.0", $version->getData()->getName());
        $this->assertEquals(7215, $version->getData()->getId());
        $this->assertEquals(31, $version->getData()->getProjectId());
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectVersions(): void
    {
        $options = new VersionSearchOptions("ViaVersion");
        $versions = $this->apiClient->getProjectVersions("ViaVersion", $options);
        $this->assertNotNull($versions);
        $this->assertNotEmpty($versions);

        foreach ($versions as $version) {
            $this->assertValidVersion($version->getData());
            $this->assertEquals(31, $version->getData()->getProjectId());
        }
    }

    /**
     * @throws ApiException
     */
    public function testGetAuthors(): void
    {
        $handler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getAuthors.json")),
        ]);
        $this->apiClient->setHttpClient(new Client(['handler' => HandlerStack::create($handler)]));

        $authors = $this->apiClient->getAuthors();
        $this->assertNotNull($authors);
        $this->assertNotEmpty($authors);

        foreach ($authors as $author) {
            $this->assertValidUser($author->getData());
        }
    }

    /**
     * @throws ApiException
     */
    public function testGetUsers(): void
    {
        $handler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUsers.json")),
        ]);
        $this->apiClient->setHttpClient(new Client(['handler' => HandlerStack::create($handler)]));

        $users = $this->apiClient->getUsers();
        $this->assertNotNull($users);
        $this->assertNotEmpty($users);

        foreach ($users as $user) {
            $this->assertValidUser($user->getData());
        }
    }

    /**
     * @throws ApiException
     */
    public function testGetUser(): void
    {
        $handler = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUser.json")),
        ]);
        $this->apiClient->setHttpClient(new Client(['handler' => HandlerStack::create($handler)]));

        $user = $this->apiClient->getUser("MiniDigger");
        $this->assertNotNull($user);
        $this->assertNotNull($user->getData());
        $this->assertEquals("MiniDigger", $user->getData()->getName());
        $this->assertEquals(1, $user->getData()->getId());
    }
}
