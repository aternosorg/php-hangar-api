<?php

namespace Aternos\HangarApi\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\List\CompactProject\PinnedProjectList;
use Aternos\HangarApi\Client\List\CompactProject\StarredProjectList;
use Aternos\HangarApi\Client\List\CompactProject\WatchedProjectList;
use Aternos\HangarApi\Client\List\ProjectList;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;

class User
{
    public function __construct(
        protected HangarAPIClient $client,
        protected \Aternos\HangarApi\Model\User $user,
    )
    {
    }

    /**
     * Get the user data
     * @return \Aternos\HangarApi\Model\User
     */
    public function getData(): \Aternos\HangarApi\Model\User
    {
        return $this->user;
    }

    /**
     * Get a list of projects this user is watching
     * @return WatchedProjectList
     * @throws ApiException
     */
    public function getWatchedProjects(): WatchedProjectList
    {
        return $this->client->getProjectsWatchedByUser($this->user->getName());
    }

    /**
     * Get a list of projects this user has starred
     * @return StarredProjectList
     * @throws ApiException
     */
    public function getStarredProjects(): StarredProjectList
    {
        return $this->client->getProjectsStarredByUser($this->user->getName());
    }

    /**
     * Get a list of projects this user has pinned
     * @return PinnedProjectList
     * @throws ApiException
     */
    public function getPinnedProjects(): PinnedProjectList
    {
        return $this->client->getProjectsPinnedByUser($this->user->getName());
    }

    /**
     * Get a list of projects owned by the user
     * @return ProjectList
     * @throws ApiException
     */
    public function getProjects(): ProjectList
    {
        $options = new ProjectSearchOptions();
        $options->setOwner($this->user->getName());
        return $this->client->getProjects($options);
    }
}