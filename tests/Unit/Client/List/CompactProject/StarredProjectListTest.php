<?php

namespace Aternos\HangarApi\Test\Unit\Client\List\CompactProject;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\CompactProject\StarredProjectList;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSortField;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSortOrder;
use Aternos\HangarApi\Model\PaginatedResultProjectCompact;
use Aternos\HangarApi\Test\Unit\Client\ClientTestCase;

class StarredProjectListTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testGetNextPageKeepsParameters(): void
    {
        $client = $this->createMock(HangarAPIClient::class);
        $list = new StarredProjectList($client, $this->createPaginatedResult(PaginatedResultProjectCompact::class), "Aternos", ProjectSortField::STARS, ProjectSortOrder::DESC, 2);
        $nextPage = new StarredProjectList($client, $this->createPaginatedResult(PaginatedResultProjectCompact::class, 2), "Aternos", ProjectSortField::STARS, ProjectSortOrder::DESC, 2);

        $client->expects($this->once())
            ->method("getProjectsStarredByUser")
            ->with("Aternos", ProjectSortField::STARS, ProjectSortOrder::DESC, 2, 2)
            ->willReturn($nextPage);

        $this->assertSame($nextPage, $list->getNextPage());
    }
}
