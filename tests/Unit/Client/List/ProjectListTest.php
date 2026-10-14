<?php

namespace Aternos\HangarApi\Test\Unit\Client\List;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\ProjectList;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
use Aternos\HangarApi\Model\PaginatedResultProject;
use Aternos\HangarApi\Test\Unit\Client\ClientTestCase;

class ProjectListTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testGetNextPageKeepsParametersWithoutModifyingOptions(): void
    {
        $client = $this->createMock(HangarAPIClient::class);
        $options = new ProjectSearchOptions()
            ->setQuery("mclogs")
            ->setLimit(2);

        $list = new ProjectList($client, $this->createPaginatedResult(PaginatedResultProject::class), $options);
        $nextPage = new ProjectList($client, $this->createPaginatedResult(PaginatedResultProject::class, 2), $options);

        $client->expects($this->once())
            ->method("getProjects")
            ->with($this->callback(fn(ProjectSearchOptions $nextOptions) => $nextOptions !== $options
                && $nextOptions->getQuery() === "mclogs"
                && $nextOptions->getOffset() === 2))
            ->willReturn($nextPage);

        $this->assertSame($nextPage, $list->getNextPage());
        $this->assertSame(0, $options->getOffset());
    }
}
