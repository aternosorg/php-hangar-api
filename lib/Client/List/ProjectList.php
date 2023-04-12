<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
use Aternos\HangarApi\Client\Project;
use Aternos\HangarApi\Model\PaginatedResultProject;
use Aternos\HangarApi\Model\Pagination;

class ProjectList extends ResultList
{
    /**
     * @var Project[]
     */
    protected array $results = [];

    public function __construct(
        protected HangarAPIClient $client,
        protected PaginatedResultProject $result,
        protected ?ProjectSearchOptions $options,
    )
    {
        $this->results = array_map(function (\Aternos\HangarApi\Model\Project $project) {
            return new Project($this->client, $project);
        }, $result->getResult());
    }

    /**
     * @return Project[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @return ProjectSearchOptions
     */
    public function getOptions(): ProjectSearchOptions
    {
        return $this->options;
    }

    /**
     * @return Pagination|null
     */
    public function getPagination(): ?Pagination
    {
        return $this->result->getPagination();
    }

    /**
     * @param int $offset
     * @return $this
     * @throws ApiException
     */
    public function getOffset(int $offset): static
    {
        $options = clone $this->options;
        $options->setOffset($offset);
        return $this->client->getProjects($options);
    }
}