<?php

namespace Aternos\HangarApi\Tests\Unit\Client\List\User;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\User\AuthorList;
use Aternos\HangarApi\Client\Options\UserSearch\AuthorSortField;
use Aternos\HangarApi\Model\PaginatedResultUser;
use Aternos\HangarApi\Tests\Unit\Client\ClientTestCase;

class AuthorListTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testGetNextPageKeepsParameters(): void
    {
        $client = $this->createMock(HangarAPIClient::class);
        $list = new AuthorList($client, $this->createPaginatedResult(PaginatedResultUser::class), "kenny", AuthorSortField::PROJECT_COUNT, 2);
        $nextPage = new AuthorList($client, $this->createPaginatedResult(PaginatedResultUser::class, 2), "kenny", AuthorSortField::PROJECT_COUNT, 2);

        $client->expects($this->once())
            ->method("getAuthors")
            ->with("kenny", AuthorSortField::PROJECT_COUNT, 2, 2)
            ->willReturn($nextPage);

        $this->assertSame($nextPage, $list->getNextPage());
    }
}
