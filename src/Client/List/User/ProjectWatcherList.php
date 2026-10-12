<?php

namespace Aternos\HangarApi\Client\List\User;

use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\UserList;
use Aternos\HangarApi\Model\PaginatedResultUser;

/**
 * Class ProjectWatcherList
 *
 * @package Aternos\HangarApi\Client\List\User
 * @description A paginated list of project watchers
 */
class ProjectWatcherList extends UserList
{
    public function __construct(
        HangarAPIClient     $client,
        PaginatedResultUser $result,
        protected string    $projectSlug,
        protected int       $limit = 25,
    )
    {
        parent::__construct($client, $result, null);
    }

    public function getOffset(int $offset): static
    {
        return $this->client->getProjectWatchers($this->projectSlug, $this->limit, $offset);
    }
}
