<?php

namespace Aternos\HangarApi\Tests\Unit\Client;

use Aternos\HangarApi\ApiException;
use GuzzleHttp\Psr7\Response;

class ProjectPageTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testFetchProjectSendsRequestOnlyOnce(): void
    {
        $client = $this->createClient([
            new Response(200, ["Content-Type" => "text/plain"], "# Main page"),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
        ]);
        $page = $client->getProjectMainPage("mclogs");

        $project = $page->fetchProject();

        $this->assertGetRequest("/projects/mclogs", index: 1);
        $this->assertSame("mclogs", $project->getSlug());
        $this->assertSame($project, $page->fetchProject());
        $this->assertCount(2, $this->requests);
    }
}
