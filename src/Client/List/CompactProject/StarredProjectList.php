<?php

namespace Aternos\HangarApi\Client\List\CompactProject;

use Aternos\HangarApi\Client\List\CompactProjectList;

/**
 * Class StarredProjectList
 *
 * @package Aternos\HangarApi\Client\List\CompactProject
 * @description A paginated list of compact projects starred by a user
 */
class StarredProjectList extends CompactProjectList
{
    public function getOffset(int $offset): static
    {
        $pagination = clone $this->requestPagination;
        $pagination->setOffset($offset);
        return $this->client->getProjectsStarredByUser($this->username, $pagination);
    }
}