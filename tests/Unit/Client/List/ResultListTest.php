<?php

namespace Aternos\HangarApi\Tests\Unit\Client\List;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\List\ResultList;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
use Aternos\HangarApi\Client\Project;
use Aternos\HangarApi\Tests\Unit\Client\ClientTestCase;
use GuzzleHttp\Psr7\Response;

/**
 * Tests the behavior that all lists share through {@see ResultList} using a project list
 */
class ResultListTest extends ClientTestCase
{
    /**
     * Response with the projects from the getProjects fixture and the given pagination
     * @param int $count total number of results for pagination
     * @param int $offset offset for pagination
     * @param int $limit limit for pagination
     * @return Response
     */
    protected function getPaginatedResponse(int $count, int $offset = 0, int $limit = 2): Response
    {
        $data = json_decode(file_get_contents(__DIR__ . "/../Fixtures/getProjects.json"), true);
        $data["pagination"] = ["count" => $count, "limit" => $limit, "offset" => $offset];
        return new Response(200, ["Content-Type" => "application/json"], json_encode($data));
    }

    /**
     * @throws ApiException
     */
    public function testFirstPageHasNextButNoPreviousPage(): void
    {
        $list = $this->createClient([$this->getPaginatedResponse(5)])->getProjects();

        $this->assertTrue($list->hasNextPage());
        $this->assertFalse($list->hasPreviousPage());
        $this->assertNull($list->getPreviousPage());
        $this->assertRequestCount(1);
    }

    /**
     * @throws ApiException
     */
    public function testLastPageHasNoNextPage(): void
    {
        $list = $this->createClient([$this->getPaginatedResponse(5, 4)])->getProjects();

        $this->assertFalse($list->hasNextPage());
        $this->assertNull($list->getNextPage());
        $this->assertTrue($list->hasPreviousPage());
        $this->assertRequestCount(1);
    }

    /**
     * @throws ApiException
     */
    public function testPageEndingExactlyAtCountHasNoNextPage(): void
    {
        $list = $this->createClient([$this->getPaginatedResponse(4, 2)])->getProjects();

        $this->assertFalse($list->hasNextPage());
    }

    /**
     * @throws ApiException
     */
    public function testGetNextPageRequestsNextOffset(): void
    {
        $client = $this->createClient([
            $this->getPaginatedResponse(5),
            $this->getPaginatedResponse(5, 2),
        ]);

        $nextPage = $client->getProjects(new ProjectSearchOptions()->setLimit(2))->getNextPage();

        $this->assertGetRequest("/projects", ["limit" => "2", "offset" => "2"], 1);
        $this->assertSame(2, $nextPage->getPagination()->getOffset());
    }

    /**
     * @throws ApiException
     */
    public function testGetPreviousPageRequestsPreviousOffset(): void
    {
        $client = $this->createClient([
            $this->getPaginatedResponse(10, 4),
            $this->getPaginatedResponse(10, 2),
        ]);

        $client->getProjects(new ProjectSearchOptions()->setOffset(4)->setLimit(2))->getPreviousPage();

        $this->assertGetRequest("/projects", ["offset" => "2"], 1);
    }

    /**
     * @throws ApiException
     */
    public function testGetPreviousPageDoesNotRequestNegativeOffset(): void
    {
        $client = $this->createClient([
            $this->getPaginatedResponse(10, 1),
            $this->getPaginatedResponse(10),
        ]);

        $client->getProjects(new ProjectSearchOptions()->setOffset(1)->setLimit(2))->getPreviousPage();

        $this->assertGetRequest("/projects", ["offset" => "0"], 1);
    }

    /**
     * @throws ApiException
     */
    public function testGetResultsFromFollowingPages(): void
    {
        $client = $this->createClient([
            $this->getPaginatedResponse(6),
            $this->getPaginatedResponse(6, 2),
            $this->getPaginatedResponse(6, 4),
        ]);

        $results = $client->getProjects(new ProjectSearchOptions()->setLimit(2))->getResultsFromFollowingPages();

        $this->assertCount(6, $results);
        $this->assertContainsOnlyInstancesOf(Project::class, $results);
        $this->assertRequestCount(3);
    }

    /**
     * @throws ApiException
     */
    public function testListCanBeUsedLikeAnArray(): void
    {
        $list = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/../Fixtures/getProjects.json"))])->getProjects();

        $this->assertCount(2, $list);
        $this->assertTrue(isset($list[1]));
        $this->assertFalse(isset($list[2]));
        $this->assertSame($list->getResults(), iterator_to_array($list));

        $list[1] = $list[0];
        $this->assertSame($list[0], $list[1]);
        unset($list[1]);
        $this->assertCount(1, $list);
    }
}
