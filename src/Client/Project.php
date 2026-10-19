<?php

namespace Aternos\HangarApi\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\List\ProjectMemberList;
use Aternos\HangarApi\Client\List\ProjectVersionList;
use Aternos\HangarApi\Client\List\UserList;
use Aternos\HangarApi\Client\Options\VersionSearch\VersionSearchOptions;
use Aternos\HangarApi\Model\DayProjectStats;
use Aternos\HangarApi\Model\Platform;
use Aternos\HangarApi\Model\Project as ProjectModel;
use DateTime;

/**
 * Class Project
 *
 * @package Aternos\HangarApi\Client
 * @description This class wraps a full project on hangar and allows you to fetch additional data.
 */
class Project extends ProjectModel
{
    /**
     * @param HangarAPIClient $client
     * @param ProjectModel $data
     */
    public function __construct(
        protected HangarAPIClient $client,
        ProjectModel              $data,
    )
    {
        parent::__construct($data->container);
    }

    /**
     * Get the slug of this project (shorthand for getNamespace()->getSlug())
     * @return string
     */
    public function getSlug(): string
    {
        return $this->getNamespace()->getSlug();
    }

    /**
     * Fetch all versions of this project (paginated)
     * This sends a request to the Hangar API every time it is called.
     * @param string|null $channel
     * @param Platform|null $platform
     * @return ProjectVersionList
     * @throws ApiException
     */
    public function fetchVersions(?string $channel = null, ?Platform $platform = null): ProjectVersionList
    {
        $options = new VersionSearchOptions($this->getId());
        $options->setProject($this);
        $options->setChannel($channel);
        $options->setPlatform($platform);
        return $this->client->getProjectVersions($this, $options);
    }

    /**
     * Fetch a single version
     * This sends a request to the Hangar API every time it is called.
     * @param string $name
     * @return Version
     * @throws ApiException
     */
    public function fetchVersion(string $name): Version
    {
        return $this->client->getVersion($this, $name);
    }

    /**
     * Fetch all watchers of this project (paginated)
     * This sends a request to the Hangar API every time it is called.
     * @return UserList
     * @throws ApiException
     */
    public function fetchWatchers(): UserList
    {
        return $this->client->getProjectWatchers($this->getId());
    }

    /**
     * Fetch a list of daily project stats
     * Days without downloads/views will not be included
     * This sends a request to the Hangar API every time it is called.
     * @param DateTime|null $from default: project creation date
     * @param DateTime|null $to default: now
     * @return array<string, DayProjectStats>
     * @throws ApiException
     */
    public function fetchDailyStats(?DateTime $from = null, ?DateTime $to = null): array
    {
        return $this->client->getDailyProjectStats(
            $this->getId(),
            $from ?? $this->getCreatedAt(),
            $to
        );
    }

    /**
     * Fetch a list of users who starred this project (paginated)
     * This sends a request to the Hangar API every time it is called.
     * @return UserList
     * @throws ApiException
     */
    public function fetchStarGazers(): UserList
    {
        return $this->client->getProjectStarGazers($this->getId());
    }

    /**
     * Fetch a list of users who are members of this project (paginated)
     * This sends a request to the Hangar API every time it is called.
     * @return ProjectMemberList
     * @throws ApiException
     */
    public function fetchMembers(): ProjectMemberList
    {
        return $this->client->getProjectMembers($this->getId());
    }

    /**
     * Fetch the owner of this project
     * This sends a request to the Hangar API every time it is called.
     * @return User
     * @throws ApiException
     */
    public function fetchOwner(): User
    {
        return $this->client->getUser($this->getNamespace()->getOwner());
    }

    /**
     * Fetch the main page of this project
     * This sends a request to the Hangar API every time it is called.
     * @return ProjectPage
     * @throws ApiException
     */
    public function fetchMainPage(): ProjectPage
    {
        return $this->client->getProjectMainPage($this->getId());
    }

    /**
     * Fetch a page of this project
     * This sends a request to the Hangar API every time it is called.
     * @param string $path
     * @return ProjectPage
     * @throws ApiException
     */
    public function fetchPage(string $path): ProjectPage
    {
        return $this->client->getProjectPage($this->getId(), $path);
    }
}
