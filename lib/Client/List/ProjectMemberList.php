<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Model\PaginatedResultProjectMember;
use Aternos\HangarApi\Model\RequestPagination;

/**
 * Class ProjectMemberList
 *
 * @package Aternos\HangarApi\Client\List
 * @description A paginated list of project members
 */
class ProjectMemberList extends ResultList
{
    public function __construct(
        protected HangarAPIClient $client,
        PaginatedResultProjectMember $result,
        protected string            $projectSlug,
        protected RequestPagination $requestPagination,
    )
    {
        parent::__construct($result->getPagination(), $result->getResult() ?? []);
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
        return $this->client->getProjectMembers($this->projectSlug, $pagination);
    }
}