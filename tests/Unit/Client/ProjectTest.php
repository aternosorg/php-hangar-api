<?php

namespace Aternos\HangarApi\Tests\Unit\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Model\Platform;
use GuzzleHttp\Psr7\Response;

class ProjectTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testGetVersions(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/listVersions.json")),
        ]);
        $project = $client->getProject("mclogs");

        $versions = $project->getVersions("Release", Platform::PAPER);

        $this->assertGetRequest("/projects/246/versions", ["channel" => "Release", "platform" => "PAPER"], 1);
        $this->assertSame($project, $versions[0]->getProject());
    }

    /**
     * @throws ApiException
     */
    public function testGetVersion(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showVersion.json")),
        ]);
        $project = $client->getProject("mclogs");

        $version = $project->getVersion("3.3.4");

        $this->assertGetRequest("/projects/246/versions/3.3.4", index: 1);
        $this->assertSame("3.3.4", $version->getName());
    }

    /**
     * @throws ApiException
     */
    public function testGetWatchers(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjectWatchers.json")),
        ]);
        $project = $client->getProject("mclogs");

        $this->assertCount(2, $project->getWatchers());
        $this->assertGetRequest("/projects/246/watchers", index: 1);
    }

    /**
     * @throws ApiException
     */
    public function testGetStarGazers(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjectStargazers.json")),
        ]);
        $project = $client->getProject("mclogs");

        $this->assertCount(2, $project->getStarGazers());
        $this->assertGetRequest("/projects/246/stargazers", index: 1);
    }

    /**
     * @throws ApiException
     */
    public function testGetMembers(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjectMembers.json")),
        ]);
        $project = $client->getProject("mclogs");

        $this->assertCount(1, $project->getMembers());
        $this->assertGetRequest("/projects/246/members", index: 1);
    }

    /**
     * @throws ApiException
     */
    public function testGetOwner(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUser.json")),
        ]);
        $project = $client->getProject("mclogs");

        $this->assertSame("Aternos", $project->getOwner()->getName());
        $this->assertGetRequest("/users/Aternos", index: 1);
    }

    /**
     * @throws ApiException
     */
    public function testGetMainPage(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
            new Response(200, ["Content-Type" => "text/plain"], "# Main page"),
        ]);
        $project = $client->getProject("mclogs");

        $this->assertSame("# Main page", $project->getMainPage()->getContent());
        $this->assertGetRequest("/pages/main/246", index: 1);
    }

    /**
     * @throws ApiException
     */
    public function testGetPage(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
            new Response(200, ["Content-Type" => "text/plain"], "# Config"),
        ]);
        $project = $client->getProject("mclogs");

        $this->assertSame("# Config", $project->getPage("config")->getContent());
        $this->assertGetRequest("/pages/page/246", ["path" => "config"], 1);
    }
}
