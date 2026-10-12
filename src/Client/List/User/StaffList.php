<?php

namespace Aternos\HangarApi\Client\List\User;

use Aternos\HangarApi\Client\List\QueryableAndSortableUserList;

/**
 * Class StaffList
 *
 * @package Aternos\HangarApi\Client\List\User
 * @description A paginated list of staff members
 */
class StaffList extends QueryableAndSortableUserList
{
    public function getOffset(int $offset): static
    {
        return $this->client->getStaff($this->query, $this->sort, $this->limit, $offset);
    }
}