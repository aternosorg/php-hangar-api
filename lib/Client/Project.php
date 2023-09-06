<?php

namespace Aternos\HangarApi\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\List\ProjectMemberList;
use Aternos\HangarApi\Client\List\ProjectVersionList;
use Aternos\HangarApi\Client\List\UserList;
use Aternos\HangarApi\Client\Options\Platform;
use Aternos\HangarApi\Client\Options\VersionSearch\VersionSearchOptions;
use Aternos\HangarApi\Model\DayProjectStats;
use DateTime;

/**
 * Class Project
 *
 * @package Aternos\HangarApi\Client
 * @description This class wraps a full project on hangar and allows you to fetch additional data.
 */
class Project
{
    public function __construct(
        protected HangarAPIClient                  $client,
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
        $options = new VersionSearchOptions($this->getData()->getNamespace());
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
     * Days without downloads/views will not be included
     * @param DateTime|null $from default: project creation date
     * @param DateTime|null $to default: now
     * @return array<string, DayProjectStats>
     * @throws ApiException
     */
    public function getDailyStats(?DateTime $from = null, ?DateTime $to = null): array
    {
        return $this->client->getDailyProjectStats(
            $this->project->getNamespace()->getSlug(),
            $from ?? $this->getData()->getCreatedAt(),
            $to
        );
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

    /**
     * Get the owner of this project
     * @return User
     * @throws ApiException
     */
    public function getOwner(): User
    {
        return $this->client->getUser($this->project->getNamespace()->getOwner());
    }

    /**
     * Get the main page of this project
     * @return ProjectPage
     * @throws ApiException
     */
    public function getMainPage(): ProjectPage
    {
        return $this->client->getProjectMainPage($this->project->getNamespace()->getSlug());
    }

    /**
     * Get a page of this project
     * @param string $path
     * @return ProjectPage
     * @throws ApiException
     */
    public function getPage(string $path): ProjectPage
    {
        return $this->client->getProjectPage($this->project->getNamespace()->getSlug(), $path);
    }
}