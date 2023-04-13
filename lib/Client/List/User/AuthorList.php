<?php

namespace Aternos\HangarApi\Client\List\User;

use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\UserList;
use Aternos\HangarApi\Model\PaginatedResultUser;
use Aternos\HangarApi\Model\RequestPagination;

/**
 * Class AuthorList
 *
 * @package Aternos\HangarApi\Client\List\User
 * @description A paginated list of authors (users that own at least one project)
 */
class AuthorList extends UserList
{
    public function __construct(HangarAPIClient $client, PaginatedResultUser $result, protected RequestPagination $requestPagination)
    {
        parent::__construct($client, $result, null);
    }

    public function getOffset(int $offset): static
    {
        $pagination = clone $this->requestPagination;
        $pagination->setOffset($offset);
        return $this->client->getAuthors($pagination);
    }
}