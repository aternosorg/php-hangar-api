<?php

namespace Aternos\HangarApi\Tests\Unit\Client;

use Aternos\HangarApi\ApiException;
use GuzzleHttp\Psr7\Response;

class VersionTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testFetchProjectSendsRequestOnlyOnce(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showVersion.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
        ]);
        $version = $client->getVersion("mclogs", "3.3.4");

        $project = $version->fetchProject();

        $this->assertGetRequest("/projects/mclogs", index: 1);
        $this->assertSame("mclogs", $project->getSlug());
        $this->assertSame($project, $version->fetchProject());
        $this->assertCount(2, $this->requests);
    }

    /**
     * @throws ApiException
     */
    public function testFetchDailyStats(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showVersion.json")),
            new Response(200, [], json_encode(["2026-01-01" => ["platformDownloads" => ["PAPER" => 2], "totalDownloads" => 2]])),
        ]);
        $version = $client->getVersion("mclogs", "3.3.4");

        $stats = $version->fetchDailyStats();

        $this->assertEquals("/api/v1/versions/30673/stats", $this->getRequest(1)->getUri()->getPath());
        $this->assertSame("2026-09-22T09:44:44+00:00", $this->getQuery(1)["fromDate"]);
        $this->assertArrayHasKey("toDate", $this->getQuery(1));
        $this->assertSame(2, $stats["2026-01-01"]->getTotalDownloads());
    }
}
