<?php

namespace Aternos\HangarApi\Client\List\User;

use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\QueryableAndSortableUserList;
use Aternos\HangarApi\Client\Options\UserSearch\AuthorSortField;
use Aternos\HangarApi\Model\PaginatedResultUser;

/**
 * Class AuthorList
 *
 * @package Aternos\HangarApi\Client\List\User
 * @description A paginated list of authors (users that own at least one project)
 */
class AuthorList extends QueryableAndSortableUserList
{
    public function __construct(
        HangarAPIClient            $client,
        PaginatedResultUser        $result,
        string                     $query,
        protected ?AuthorSortField $sort = null,
        int                        $limit = 25,
    )
    {
        parent::__construct($client, $result, $query, $limit);
    }

    public function getOffset(int $offset): static
    {
        return $this->client->getAuthors($this->query, $this->sort, $this->limit, $offset);
    }
}
