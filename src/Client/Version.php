<?php

namespace Aternos\HangarApi\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Model\Version as VersionModel;
use Aternos\HangarApi\Model\VersionStats;
use DateTime;

/**
 * Class Version
 *
 * @package Aternos\HangarApi\Client
 * @description This class wraps a version of a project on hangar and allows you to fetch additional data.
 */
class Version extends VersionModel
{
    /**
     * @param HangarAPIClient $client
     * @param VersionModel $data
     * @param string $projectSlugOrId slug or id of the project this version belongs to
     * @param Project|null $project the project this version belongs to, if it is already known
     */
    public function __construct(
        protected HangarAPIClient $client,
        VersionModel              $data,
        protected string          $projectSlugOrId,
        protected ?Project        $project = null,
    )
    {
        parent::__construct($data->container);
    }

    /**
     * Get the slug or id of the project this version belongs to
     * @return string
     */
    public function getProjectSlugOrId(): string
    {
        return $this->projectSlugOrId;
    }

    /**
     * Get the project this version belongs to
     * @return Project
     * @throws ApiException
     */
    public function getProject(): Project
    {
        if ($this->project) {
            return $this->project;
        }

        $this->project = $this->client->getProject($this->projectSlugOrId);
        return $this->project;
    }

    /**
     * Fetch a daily list of statistics for this version
     * Days without downloads/views are not be included
     * @param DateTime|null $from default: version creation date
     * @param DateTime|null $to default: now
     * @return array<string, VersionStats>
     * @throws ApiException
     */
    public function getDailyStats(?DateTime $from = null, ?DateTime $to = null): array
    {
        return $this->client->getDailyVersionStatsById(
            $this->getId(),
            $from ?? $this->getCreatedAt(),
            $to
        );
    }
}
