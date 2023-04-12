<?php

namespace Aternos\HangarApi\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\Options\Platform;
use Aternos\HangarApi\Model\ProjectNamespace;
use Aternos\HangarApi\Model\VersionStats;
use DateTime;

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
     * @param Platform $platform
     * @param DateTime|null $from
     * @param DateTime|null $to
     * @return VersionStats[]
     * @throws ApiException
     */
    public function getStats(Platform $platform, ?DateTime $from = null, ?DateTime $to = null): array
    {
        return $this->client->getProjectVersionDayStats($this, $platform, $from, $to);
    }
}