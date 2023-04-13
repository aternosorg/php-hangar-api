<?php

namespace Aternos\HangarApi\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\Options\Platform;
use Aternos\HangarApi\Model\ProjectNamespace;
use Aternos\HangarApi\Model\VersionStats;
use DateTime;

/**
 * Class Version
 *
 * @package Aternos\HangarApi\Client
 * @description This class wraps a version of a project on hangar and allows you to fetch additional data.
 */
class Version
{
    public function __construct(
        protected HangarAPIClient                  $client,
        protected \Aternos\HangarApi\Model\Version $version,
        protected ProjectNamespace                 $projectNamespace,
        protected ?Project                         $project = null,
    )
    {
    }

    /**
     * @return ProjectNamespace
     */
    public function getProjectNamespace(): ProjectNamespace
    {
        return $this->projectNamespace;
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

        $this->project = $this->client->getProject($this->projectNamespace->getOwner(), $this->projectNamespace->getSlug());
        return $this->project;
    }

    /**
     * @return \Aternos\HangarApi\Model\Version
     */
    public function getData(): \Aternos\HangarApi\Model\Version
    {
        return $this->version;
    }

    /**
     * Fetch a daily list of statistics for this version
     * Days without downloads/views are not be included
     * @param Platform $platform
     * @param DateTime|null $from default: version creation date
     * @param DateTime|null $to default: now
     * @return array<string, VersionStats>
     * @throws ApiException
     */
    public function getDailyStats(Platform $platform, ?DateTime $from = null, ?DateTime $to = null): array
    {
        return $this->client->getDailyProjectVersionStats(
            $this,
            $platform,
            $from ?? $this->getData()->getCreatedAt(),
            $to
        );
    }
}