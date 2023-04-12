<?php

namespace Aternos\HangarApi\Client\List\CompactProject;

use Aternos\HangarApi\Client\List\CompactProjectList;

class WatchedProjectList extends CompactProjectList
{
    public function getOffset(int $offset): static
    {
        $pagination = clone $this->requestPagination;
        $pagination->setOffset($offset);
        return $this->client->getProjectsWatchedByUser($this->username, $pagination);
    }
}