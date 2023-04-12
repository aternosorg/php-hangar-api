<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\Options\VersionSearch\VersionSearchOptions;
use Aternos\HangarApi\Client\Version;
use Aternos\HangarApi\Model\PaginatedResultVersion;
use Aternos\HangarApi\Model\Pagination;

class ProjectVersionList extends ResultList
{
    /**
     * @var Version[]
     */
    protected array $results = [];

    public function __construct(
        protected HangarAPIClient $client,
        protected PaginatedResultVersion $result,
        protected VersionSearchOptions $options,
    )
    {
        $this->results = array_map(function (\Aternos\HangarApi\Model\Version $version) use ($options) {
            return new Version(
                $this->client,
                $version,
                $options->getProjectNamespace(),
                $options->getProject(),
            );
        }, $result->getResult());
    }

    /**
     * @return Version[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    public function getPagination(): ?Pagination
    {
        return $this->result->getPagination();
    }

    public function getOffset(int $offset): static
    {
        $options = clone $this->options;
        $options->setOffset($offset);
        return $this->client->getProjectVersions(
            $this->options->getProject() ?? $this->options->getProjectNamespace(),
            $options
        );
    }
}