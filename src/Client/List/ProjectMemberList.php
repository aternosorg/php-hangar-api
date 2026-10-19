<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Model\PaginatedResultProjectMember;
use Aternos\HangarApi\Model\ProjectMember;

/**
 * Class ProjectMemberList
 *
 * @package Aternos\HangarApi\Client\List
 * @description A paginated list of project members
 * @extends PaginatedList<ProjectMember>
 */
class ProjectMemberList extends PaginatedList
{
    public function __construct(
        protected HangarAPIClient    $client,
        PaginatedResultProjectMember $result,
        protected string             $projectSlug,
        protected int                $limit = 25,
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
        return $this->client->getProjectMembers($this->projectSlug, $this->limit, $offset);
    }
}
