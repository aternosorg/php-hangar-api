<?php

namespace Aternos\HangarApi\Test\Unit\Client\List;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\ProjectMemberList;
use Aternos\HangarApi\Model\PaginatedResultProjectMember;
use Aternos\HangarApi\Test\Unit\Client\ClientTestCase;

class ProjectMemberListTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testGetNextPageKeepsParameters(): void
    {
        $client = $this->createMock(HangarAPIClient::class);
        $list = new ProjectMemberList($client, $this->createPaginatedResult(PaginatedResultProjectMember::class), "mclogs", 2);
        $nextPage = new ProjectMemberList($client, $this->createPaginatedResult(PaginatedResultProjectMember::class, 2), "mclogs", 2);

        $client->expects($this->once())
            ->method("getProjectMembers")
            ->with("mclogs", 2, 2)
            ->willReturn($nextPage);

        $this->assertSame($nextPage, $list->getNextPage());
    }
}
