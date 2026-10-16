<?php

namespace Aternos\HangarApi\Tests\Unit\Client\List;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\ProjectVersionList;
use Aternos\HangarApi\Client\Options\VersionSearch\VersionSearchOptions;
use Aternos\HangarApi\Client\Project;
use Aternos\HangarApi\Model\PaginatedResultVersion;
use Aternos\HangarApi\Model\Project as ProjectModel;
use Aternos\HangarApi\Tests\Unit\Client\ClientTestCase;

class ProjectVersionListTest extends ClientTestCase
{
    /**
     * @throws ApiException
     */
    public function testGetNextPageKeepsParametersWithoutModifyingOptions(): void
    {
        $client = $this->createMock(HangarAPIClient::class);
        $options = new VersionSearchOptions("mclogs")
            ->setChannel("Release")
            ->setLimit(2);

        $list = new ProjectVersionList($client, $this->createPaginatedResult(PaginatedResultVersion::class), $options);
        $nextPage = new ProjectVersionList($client, $this->createPaginatedResult(PaginatedResultVersion::class, 2), $options);

        $client->expects($this->once())
            ->method("getProjectVersions")
            ->with(
                $this->identicalTo("mclogs"),
                $this->callback(fn(VersionSearchOptions $nextOptions) => $nextOptions !== $options
                    && $nextOptions->getChannel() === "Release"
                    && $nextOptions->getOffset() === 2),
            )
            ->willReturn($nextPage);

        $this->assertSame($nextPage, $list->getNextPage());
        $this->assertSame(0, $options->getOffset());
    }

    /**
     * @throws ApiException
     */
    public function testGetNextPageOfProjectUsesProject(): void
    {
        $client = $this->createMock(HangarAPIClient::class);
        $project = new Project($client, new ProjectModel(["id" => 246]));
        $options = new VersionSearchOptions("mclogs")
            ->setProject($project)
            ->setChannel("Release")
            ->setLimit(2);

        $list = new ProjectVersionList($client, $this->createPaginatedResult(PaginatedResultVersion::class), $options);
        $nextPage = new ProjectVersionList($client, $this->createPaginatedResult(PaginatedResultVersion::class, 2), $options);

        $client->expects($this->once())
            ->method("getProjectVersions")
            ->with(
                $this->identicalTo($project),
                $this->callback(fn(VersionSearchOptions $nextOptions) => $nextOptions !== $options
                    && $nextOptions->getChannel() === "Release"
                    && $nextOptions->getOffset() === 2),
            )
            ->willReturn($nextPage);

        $this->assertSame($nextPage, $list->getNextPage());
        $this->assertSame(0, $options->getOffset());
    }
}
