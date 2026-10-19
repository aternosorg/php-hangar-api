<?php

namespace Aternos\HangarApi\Client\List;

use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\Options\VersionSearch\VersionSearchOptions;
use Aternos\HangarApi\Client\Version;
use Aternos\HangarApi\Model\PaginatedResultVersion;
use Aternos\HangarApi\Model\Version as VersionModel;

/**
 * Class ProjectVersionList
 *
 * @package Aternos\HangarApi\Client\List
 * @description A paginated list of versions
 * @extends PaginatedList<Version>
 */
class ProjectVersionList extends PaginatedList
{
    public function __construct(
        protected HangarAPIClient      $client,
        PaginatedResultVersion         $result,
        protected VersionSearchOptions $options,
    )
    {
        parent::__construct($result->getPagination(), array_map(function (VersionModel $version) use ($options) {
            return new Version(
                $this->client,
                $version,
                $options->getProjectSlugOrId(),
                $options->getProject(),
            );
        }, $result->getResult()));
    }

    public function getOffset(int $offset): static
    {
        $options = clone $this->options;
        $options->setOffset($offset);
        return $this->client->getProjectVersions(
            $options->getProject() ?? $options->getProjectSlugOrId(),
            $options
        );
    }
}
