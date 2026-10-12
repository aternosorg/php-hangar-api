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
        $pagination = clone $this->requestPagination;
        $pagination->setOffset($offset);
        return $this->client->getStaff($this->query, $pagination, $this->sort);
    }
}