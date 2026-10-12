<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\Client\CompactProject;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Model\PaginatedResultProjectCompact;
use Aternos\HangarApi\Model\ProjectCompact as CompactProjectModel;
use Aternos\HangarApi\Model\RequestPagination;

/**
 * Class CompactProjectList
 *
 * @package Aternos\HangarApi\Client\List
 * @description A paginated list of compact projects
 * @extends ResultList<CompactProject>
 */
abstract class CompactProjectList extends ResultList
{
    public function __construct(
        protected HangarAPIClient               $client,
        PaginatedResultProjectCompact $result,
        protected string                        $username,
        protected RequestPagination             $requestPagination,
    )
    {
        parent::__construct($result->getPagination(), array_map(function (CompactProjectModel $project) {
            return new CompactProject($this->client, $project);
        }, $result->getResult()));
    }
}