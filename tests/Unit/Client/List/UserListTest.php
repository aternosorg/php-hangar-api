<?php

namespace Aternos\HangarApi\Tests\Unit\Client\List;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\UserList;
use Aternos\HangarApi\Client\Options\UserSearch\UserSearchOptions;
use Aternos\HangarApi\Model\PaginatedResultUser;
use Aternos\HangarApi\Tests\Unit\Client\ClientTestCase;

class UserListTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testGetNextPageKeepsParametersWithoutModifyingOptions(): void
    {
        $client = $this->createMock(HangarAPIClient::class);
        $options = new UserSearchOptions()->setQuery("kenny")->setLimit(2);
        $list = new UserList($client, $this->createPaginatedResult(PaginatedResultUser::class), $options);
        $nextPage = new UserList($client, $this->createPaginatedResult(PaginatedResultUser::class, 2), $options);

        $client->expects($this->once())
            ->method("getUsers")
            ->with($this->callback(fn(UserSearchOptions $nextOptions) => $nextOptions !== $options
                && $nextOptions->getQuery() === "kenny"
                && $nextOptions->getOffset() === 2))
            ->willReturn($nextPage);

        $this->assertSame($nextPage, $list->getNextPage());
        $this->assertSame(0, $options->getOffset());
    }
}
