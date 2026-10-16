<?php

namespace Aternos\HangarApi\Tests\Unit\Client\List\User;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\User\ProjectWatcherList;
use Aternos\HangarApi\Model\PaginatedResultUser;
use Aternos\HangarApi\Tests\Unit\Client\ClientTestCase;

class ProjectWatcherListTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testGetNextPageKeepsParameters(): void
    {
        $client = $this->createMock(HangarAPIClient::class);
        $list = new ProjectWatcherList($client, $this->createPaginatedResult(PaginatedResultUser::class), "mclogs", 2);
        $nextPage = new ProjectWatcherList($client, $this->createPaginatedResult(PaginatedResultUser::class, 2), "mclogs", 2);

        $client->expects($this->once())
            ->method("getProjectWatchers")
            ->with("mclogs", 2, 2)
            ->willReturn($nextPage);

        $this->assertSame($nextPage, $list->getNextPage());
    }
}
