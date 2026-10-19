<?php

namespace Aternos\HangarApi\Tests\Unit\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\CompactProject;
use Aternos\HangarApi\Client\Project;
use GuzzleHttp\Psr7\Response;

class UserTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testFetchWatchedProjects(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUser.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUserWatching.json")),
        ]);
        $user = $client->getUser("Aternos");

        $projects = $user->fetchWatchedProjects();

        $this->assertGetRequest("/users/196/watching", index: 1);
        $this->assertContainsOnlyInstancesOf(CompactProject::class, $projects->getResults());
    }

    /**
     * @throws ApiException
     */
    public function testFetchStarredProjects(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUser.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showStarred.json")),
        ]);
        $user = $client->getUser("Aternos");

        $projects = $user->fetchStarredProjects();

        $this->assertGetRequest("/users/196/starred", index: 1);
        $this->assertContainsOnlyInstancesOf(CompactProject::class, $projects->getResults());
    }

    /**
     * @throws ApiException
     */
    public function testFetchPinnedProjects(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUser.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUserPinnedProjects.json")),
        ]);
        $user = $client->getUser("Aternos");

        $projects = $user->fetchPinnedProjects();

        $this->assertGetRequest("/users/196/pinned", index: 1);
        $this->assertContainsOnlyInstancesOf(CompactProject::class, $projects);
    }

    /**
     * @throws ApiException
     */
    public function testFetchProjects(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUser.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjects.json")),
        ]);
        $user = $client->getUser("Aternos");

        $projects = $user->fetchProjects();

        $this->assertGetRequest("/projects", ["owner" => "Aternos"], 1);
        $this->assertContainsOnlyInstancesOf(Project::class, $projects->getResults());
    }
}
