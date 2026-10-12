<?php

namespace Aternos\HangarApi\Client\List\CompactProject;

use Aternos\HangarApi\Client\List\CompactProjectList;

/**
 * Class WatchedProjectList
 *
 * @package Aternos\HangarApi\Client\List\CompactProject
 * @description A paginated list of compact projects watched by a user
 */
class WatchedProjectList extends CompactProjectList
{
    public function getOffset(int $offset): static
    {
        $pagination = clone $this->requestPagination;
        $pagination->setOffset($offset);
        return $this->client->getProjectsWatchedByUser($this->username, $pagination);
    }
}