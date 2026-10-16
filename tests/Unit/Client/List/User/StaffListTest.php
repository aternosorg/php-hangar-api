<?php

namespace Aternos\HangarApi\Tests\Unit\Client\List\User;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\User\StaffList;
use Aternos\HangarApi\Client\Options\UserSearch\StaffSortField;
use Aternos\HangarApi\Model\PaginatedResultUser;
use Aternos\HangarApi\Tests\Unit\Client\ClientTestCase;

class StaffListTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testGetNextPageKeepsParameters(): void
    {
        $client = $this->createMock(HangarAPIClient::class);
        $list = new StaffList($client, $this->createPaginatedResult(PaginatedResultUser::class), "mini", StaffSortField::ROLES, 2);
        $nextPage = new StaffList($client, $this->createPaginatedResult(PaginatedResultUser::class, 2), "mini", StaffSortField::ROLES, 2);

        $client->expects($this->once())
            ->method("getStaff")
            ->with("mini", StaffSortField::ROLES, 2, 2)
            ->willReturn($nextPage);

        $this->assertSame($nextPage, $list->getNextPage());
    }
}
