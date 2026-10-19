<?php

namespace Aternos\HangarApi\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\List\CompactProject\StarredProjectList;
use Aternos\HangarApi\Client\List\CompactProject\WatchedProjectList;
use Aternos\HangarApi\Client\List\ProjectList;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
use Aternos\HangarApi\Model\User as UserModel;

/**
 * Class User
 *
 * @package Aternos\HangarApi\Client
 * @description This class wraps a hangar user and allows you to fetch additional data.
 */
class User extends UserModel
{
    /**
     * @param HangarAPIClient $client
     * @param UserModel $data
     */
    public function __construct(
        protected HangarAPIClient $client,
        UserModel                 $data,
    )
    {
        parent::__construct($data->container);
    }

    /**
     * Fetch a list of projects this user is watching
     * This sends a request to the Hangar API every time it is called.
     * @return WatchedProjectList
     * @throws ApiException
     */
    public function fetchWatchedProjects(): WatchedProjectList
    {
        return $this->client->getProjectsWatchedByUser($this->getId());
    }

    /**
     * Fetch a list of projects this user has starred
     * This sends a request to the Hangar API every time it is called.
     * @return StarredProjectList
     * @throws ApiException
     */
    public function fetchStarredProjects(): StarredProjectList
    {
        return $this->client->getProjectsStarredByUser($this->getId());
    }

    /**
     * Fetch a list of projects this user has pinned
     * This sends a request to the Hangar API every time it is called.
     * @return CompactProject[]
     * @throws ApiException
     */
    public function fetchPinnedProjects(): array
    {
        return $this->client->getProjectsPinnedByUser($this->getId());
    }

    /**
     * Fetch a list of projects owned by the user
     * The projects are searched by the name of the user, see {@see ProjectSearchOptions::setOwner()}
     * This sends a request to the Hangar API every time it is called.
     * @return ProjectList
     * @throws ApiException
     */
    public function fetchProjects(): ProjectList
    {
        $options = new ProjectSearchOptions();
        $options->setOwner($this->getName());
        return $this->client->getProjects($options);
    }
}
