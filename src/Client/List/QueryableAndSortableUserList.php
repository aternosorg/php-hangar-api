<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Model\PaginatedResultUser;
use Aternos\HangarApi\Model\RequestPagination;

/**
 * This class enhances the UserList and gives it the ability to be queried and sorted.
 * The search query parameter is required and the sort parameter is optional.
 *
 * @package Aternos\HangarApi\Client\List
 * @description A queryable and paginated list of users
 * @extends UserList
 */
class QueryableAndSortableUserList extends UserList
{

    public function __construct(
        HangarAPIClient $client,
        PaginatedResultUser $result,
        protected RequestPagination $requestPagination,
        protected string $query,
        protected ?string $sort = null,
    )
    {
        parent::__construct($client, $result, null);
    }

}