<?php

namespace Aternos\HangarApi\Client\List\User;

use Aternos\HangarApi\Client\List\QueryableAndSortableUserList;

/**
 * Class AuthorList
 *
 * @package Aternos\HangarApi\Client\List\User
 * @description A paginated list of authors (users that own at least one project)
 */
class AuthorList extends QueryableAndSortableUserList
{
    public function getOffset(int $offset): static
    {
        $pagination = clone $this->requestPagination;
        $pagination->setOffset($offset);
        return $this->client->getAuthors($this->query, $pagination, $this->sort);
    }
}