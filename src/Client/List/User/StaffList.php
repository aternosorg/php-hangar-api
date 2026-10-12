<?php

namespace Aternos\HangarApi\Client\List\User;

use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\QueryableAndSortableUserList;
use Aternos\HangarApi\Client\Options\UserSearch\StaffSortField;
use Aternos\HangarApi\Model\PaginatedResultUser;

/**
 * Class StaffList
 *
 * @package Aternos\HangarApi\Client\List\User
 * @description A paginated list of staff members
 */
class StaffList extends QueryableAndSortableUserList
{
    public function __construct(
        HangarAPIClient           $client,
        PaginatedResultUser       $result,
        string                    $query,
        protected ?StaffSortField $sort = null,
        int                       $limit = 25,
    )
    {
        parent::__construct($client, $result, $query, $limit);
    }

    public function getOffset(int $offset): static
    {
        return $this->client->getStaff($this->query, $this->sort, $this->limit, $offset);
    }
}
