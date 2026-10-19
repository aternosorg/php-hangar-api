<?php

namespace Aternos\HangarApi\Tests\Unit\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\Project;
use GuzzleHttp\Psr7\Response;

class CompactProjectTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testFetchProject(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showStarred.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
        ]);
        $compactProject = $client->getProjectsStarredByUser("Aternos")[0];

        $this->assertInstanceOf(Project::class, $compactProject->fetchProject());
        $this->assertGetRequest("/projects/246", index: 1);
    }

    /**
     * @throws ApiException
     */
    public function testFetchVersions(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showStarred.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/listVersions.json")),
        ]);
        $project = $client->getProjectsStarredByUser("Aternos")[0];

        $versions = $project->fetchVersions("Release");

        $this->assertGetRequest("/projects/246/versions", ["channel" => "Release"], 1);
        $this->assertSame("246", $versions[0]->getProjectSlugOrId());
    }

    /**
     * @throws ApiException
     */
    public function testFetchVersion(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showStarred.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showVersion.json")),
        ]);
        $project = $client->getProjectsStarredByUser("Aternos")[0];

        $project->fetchVersion("3.3.4");

        $this->assertGetRequest("/projects/246/versions/3.3.4", index: 1);
    }

    /**
     * @throws ApiException
     */
    public function testFetchWatchers(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showStarred.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjectWatchers.json")),
        ]);
        $project = $client->getProjectsStarredByUser("Aternos")[0];

        $this->assertCount(2, $project->fetchWatchers());
        $this->assertGetRequest("/projects/246/watchers", index: 1);
    }

    /**
     * @throws ApiException
     */
    public function testFetchStarGazers(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showStarred.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjectStargazers.json")),
        ]);
        $project = $client->getProjectsStarredByUser("Aternos")[0];

        $this->assertCount(2, $project->fetchStarGazers());
        $this->assertGetRequest("/projects/246/stargazers", index: 1);
    }

    /**
     * @throws ApiException
     */
    public function testFetchMembers(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showStarred.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjectMembers.json")),
        ]);
        $project = $client->getProjectsStarredByUser("Aternos")[0];

        $this->assertCount(1, $project->fetchMembers());
        $this->assertGetRequest("/projects/246/members", index: 1);
    }

    /**
     * @throws ApiException
     */
    public function testFetchOwner(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showStarred.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUser.json")),
        ]);
        $project = $client->getProjectsStarredByUser("Aternos")[0];

        $project->fetchOwner();

        $this->assertGetRequest("/users/Aternos", index: 1);
    }

    /**
     * @throws ApiException
     */
    public function testFetchDailyStats(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUserPinnedProjects.json")),
            new Response(200, [], json_encode(["token" => "test-jwt", "expiresIn" => 3600])),
            new Response(200, [], json_encode(["result" => true])),
            new Response(200, [], json_encode(["2026-01-01" => ["downloads" => 3, "views" => 5]])),
        ]);
        $project = $client->getProjectsPinnedByUser("Aternos")[0];
        $client->setApiKey("test-api-key");

        $stats = $project->fetchDailyStats();

        $this->assertEquals("/api/v1/authenticate", $this->getRequest(1)->getUri()->getPath());
        $this->assertGetRequest("/permissions/hasAll", ["permissions" => "is_subject_member", "project" => "246"], 2);
        $this->assertEquals("/api/v1/projects/246/stats", $this->getRequest(3)->getUri()->getPath());
        $this->assertSame("2023-04-05T09:53:36+00:00", $this->getQuery(3)["fromDate"]);
        $this->assertArrayHasKey("toDate", $this->getQuery(3));
        $this->assertSame(3, $stats["2026-01-01"]->getDownloads());
    }

    /**
     * @throws ApiException
     */
    public function testFetchMainPage(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showStarred.json")),
            new Response(200, ["Content-Type" => "text/plain"], "# Main page"),
        ]);
        $project = $client->getProjectsStarredByUser("Aternos")[0];

        $this->assertSame("# Main page", $project->fetchMainPage()->getContent());
        $this->assertGetRequest("/pages/main/246", index: 1);
    }

    /**
     * @throws ApiException
     */
    public function testFetchPage(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showStarred.json")),
            new Response(200, ["Content-Type" => "text/plain"], "# Config"),
        ]);
        $project = $client->getProjectsStarredByUser("Aternos")[0];

        $this->assertSame("# Config", $project->fetchPage("config")->getContent());
        $this->assertGetRequest("/pages/page/246", ["path" => "config"], 1);
    }
}
