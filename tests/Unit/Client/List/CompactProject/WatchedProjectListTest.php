<?php

namespace Aternos\HangarApi\Tests\Unit\Client\List\CompactProject;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\CompactProject\WatchedProjectList;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSortField;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSortOrder;
use Aternos\HangarApi\Model\PaginatedResultProjectCompact;
use Aternos\HangarApi\Tests\Unit\Client\ClientTestCase;

class WatchedProjectListTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testGetNextPageKeepsParameters(): void
    {
        $client = $this->createMock(HangarAPIClient::class);
        $list = new WatchedProjectList($client, $this->createPaginatedResult(PaginatedResultProjectCompact::class), "Aternos", ProjectSortField::DOWNLOADS, ProjectSortOrder::ASC, 2);
        $nextPage = new WatchedProjectList($client, $this->createPaginatedResult(PaginatedResultProjectCompact::class, 2), "Aternos", ProjectSortField::DOWNLOADS, ProjectSortOrder::ASC, 2);

        $client->expects($this->once())
            ->method("getProjectsWatchedByUser")
            ->with("Aternos", ProjectSortField::DOWNLOADS, ProjectSortOrder::ASC, 2, 2)
            ->willReturn($nextPage);

        $this->assertSame($nextPage, $list->getNextPage());
    }
}
