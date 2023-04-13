<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Model\PaginatedResultProjectMember;
use Aternos\HangarApi\Model\Pagination;
use Aternos\HangarApi\Model\ProjectMember;
use Aternos\HangarApi\Model\ProjectNamespace;
use Aternos\HangarApi\Model\RequestPagination;

/**
 * Class ProjectMemberList
 *
 * @package Aternos\HangarApi\Client\List
 * @description A paginated list of project members
 */
class ProjectMemberList
{
    public function __construct(
        protected HangarAPIClient $client,
        protected PaginatedResultProjectMember $result,
        protected ProjectNamespace  $namespace,
        protected RequestPagination $requestPagination,
    )
    {
    }

    /**
     * @return ProjectMember[]|null
     */
    public function getResults(): ?array
    {
        return $this->result->getResult();
    }

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
        $pagination = clone $this->requestPagination;
        $pagination->setOffset($offset);
        return $this->client->getProjectMembers($this->namespace, $pagination);
    }
}