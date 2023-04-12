<?php

namespace Aternos\HangarApi\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\List\ProjectMemberList;
use Aternos\HangarApi\Client\List\ProjectVersionList;
use Aternos\HangarApi\Client\List\UserList;
use Aternos\HangarApi\Client\Options\Platform;
use Aternos\HangarApi\Client\Options\VersionSearch\VersionSearchOptions;
use Aternos\HangarApi\Model\ProjectStats;
use DateTime;

class Project
{
    public function __construct(
        protected HangarAPIClient $client,
        protected \Aternos\HangarApi\Model\Project $project,
    )
    {
    }

    /**
     * @return \Aternos\HangarApi\Model\Project
     */
    public function getData(): \Aternos\HangarApi\Model\Project
    {
        return $this->project;
    }

    /**
     * Get all versions of this project (paginated)
     * @param string|null $channel
     * @param Platform|null $platform
     * @param string|null $platformVersion
     * @return ProjectVersionList
     * @throws ApiException
     */
    public function getVersions(?string $channel = null, ?Platform $platform = null, ?string $platformVersion = null): ProjectVersionList
    {
        $options = new VersionSearchOptions();
        $options->setProject($this);
        $options->setChannel($channel);
        $options->setPlatform($platform);
        $options->setPlatformVersion($platformVersion);
        return $this->client->getProjectVersions($this->project->getNamespace(), $options);
    }

    /**
     * get a single version
     * @param string $name
     * @return Version
     * @throws ApiException
     */
    public function getVersion(string $name): Version
    {
        return $this->client->getProjectVersion($this, $name);
    }

    /**
     * Get all watchers of this project (paginated)
     * @return UserList
     * @throws ApiException
     */
    public function getWatchers(): UserList
    {
        return $this->client->getProjectWatchers($this->project->getNamespace());
    }

    /**
     * Get a list of daily project stats
     * defaults to only returning the stats for today
     * @param DateTime|null $from
     * @param DateTime|null $to
     * @return ProjectStats[]
     * @throws ApiException
     */
    public function getDayStats(?DateTime $from = null, ?DateTime $to = null): array
    {
        return $this->client->getProjectDayStats($this->project->getNamespace(), $from, $to);
    }

    /**
     * Get a list of users who starred this project (paginated)
     * @return UserList
     * @throws ApiException
     */
    public function getStarGazers(): UserList
    {
        return $this->client->getProjectStarGazers($this->project->getNamespace());
    }

    /**
     * Get a list of users who are members of this project (paginated)
     * @return ProjectMemberList
     * @throws ApiException
     */
    public function getMembers(): ProjectMemberList
    {
        return $this->client->getProjectMembers($this->project->getNamespace());
    }
}