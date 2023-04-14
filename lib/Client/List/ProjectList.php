<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
use Aternos\HangarApi\Client\Project;
use Aternos\HangarApi\Model\PaginatedResultProject;
use Aternos\HangarApi\Model\Project as ProjectModel;

/**
 * Class ProjectList
 *
 * @package Aternos\HangarApi\Client\List
 * @description A paginated list of projects
 * @extends ResultList<Project>
 */
class ProjectList extends ResultList
{
    public function __construct(
        protected HangarAPIClient $client,
        PaginatedResultProject $result,
        protected ?ProjectSearchOptions $options,
    )
    {
        parent::__construct($result->getPagination(), array_map(function (ProjectModel $project) {
            return new Project($this->client, $project);
        }, $result->getResult()));
    }

    /**
     * @return ProjectSearchOptions
     */
    public function getOptions(): ProjectSearchOptions
    {
        return $this->options;
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