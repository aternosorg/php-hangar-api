<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\Client\CompactProject;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Model\PaginatedResultProjectCompact;
use Aternos\HangarApi\Model\Pagination;
use Aternos\HangarApi\Model\RequestPagination;

/**
 * Class CompactProjectList
 *
 * @package Aternos\HangarApi\Client\List
 * @description A paginated list of compact projects
 */
abstract class CompactProjectList extends ResultList
{
    /**
     * @var CompactProject[]
     */
    protected array $results = [];

    public function __construct(
        protected HangarAPIClient               $client,
        protected PaginatedResultProjectCompact $result,
        protected string                        $username,
        protected RequestPagination             $requestPagination,
    )
    {
        $this->results = array_map(function (\Aternos\HangarApi\Model\ProjectCompact $project) {
            return new CompactProject($this->client, $project);
        }, $result->getResult());
    }

    /**
     * @return CompactProject[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    public function getPagination(): ?Pagination
    {
        return $this->result->getPagination();
    }
}