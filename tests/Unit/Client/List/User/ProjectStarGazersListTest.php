<?php

namespace Aternos\HangarApi\Tests\Unit\Client\List\User;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\User\ProjectStarGazersList;
use Aternos\HangarApi\Model\PaginatedResultUser;
use Aternos\HangarApi\Tests\Unit\Client\ClientTestCase;

class ProjectStarGazersListTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testGetNextPageKeepsParameters(): void
    {
        $client = $this->createMock(HangarAPIClient::class);
        $list = new ProjectStarGazersList($client, $this->createPaginatedResult(PaginatedResultUser::class), "mclogs", 2);
        $nextPage = new ProjectStarGazersList($client, $this->createPaginatedResult(PaginatedResultUser::class, 2), "mclogs", 2);

        $client->expects($this->once())
            ->method("getProjectStarGazers")
            ->with("mclogs", 2, 2)
            ->willReturn($nextPage);

        $this->assertSame($nextPage, $list->getNextPage());
    }
}
