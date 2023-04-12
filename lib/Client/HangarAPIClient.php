<?php

namespace Aternos\HangarApi\Client;

use Aternos\HangarApi\Api\AuthenticationApi;
use Aternos\HangarApi\Api\ProjectsApi;
use Aternos\HangarApi\Api\UsersApi;
use Aternos\HangarApi\Api\VersionsApi;
use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\List\CompactProject\PinnedProjectList;
use Aternos\HangarApi\Client\List\CompactProject\StarredProjectList;
use Aternos\HangarApi\Client\List\ProjectList;
use Aternos\HangarApi\Client\List\ProjectMemberList;
use Aternos\HangarApi\Client\List\ProjectVersionList;
use Aternos\HangarApi\Client\List\User\AuthorList;
use Aternos\HangarApi\Client\List\User\ProjectStarGazersList;
use Aternos\HangarApi\Client\List\User\ProjectWatcherList;
use Aternos\HangarApi\Client\List\User\StaffList;
use Aternos\HangarApi\Client\List\UserList;
use Aternos\HangarApi\Client\List\CompactProject\WatchedProjectList;
use Aternos\HangarApi\Client\Options\Platform;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
use Aternos\HangarApi\Client\Options\UserSearch\UserSearchOptions;
use Aternos\HangarApi\Client\Options\VersionSearch\VersionSearchOptions;
use Aternos\HangarApi\Configuration;
use Aternos\HangarApi\Model\DayProjectStats;
use Aternos\HangarApi\Model\ProjectNamespace;
use Aternos\HangarApi\Model\RequestPagination;
use DateTime;

class HangarAPIClient
{

    protected Configuration $configuration;

    protected ?string $apiKey = null;

    protected ?JWT $jwt = null;

    protected ProjectsApi $projects;

    protected VersionsApi $versions;

    protected UsersApi $users;

    protected AuthenticationApi $authentication;

    public function __construct(Configuration $configuration = null)
    {
        $this->setConfiguration($configuration ?? (new Configuration())
            ->setUserAgent("php-hangar-api/1.0.0"));
    }

    /**
     * @param Configuration $configuration
     * @return $this
     */
    public function setConfiguration(Configuration $configuration): static
    {
        $this->configuration = $configuration;
        $this->projects = new ProjectsApi(null, $this->configuration);
        $this->versions = new VersionsApi(null, $this->configuration);
        $this->users = new UsersApi(null, $this->configuration);
        $this->authentication = new AuthenticationApi(null, $this->configuration);
        return $this;
    }

    /**
     * @throws ApiException
     */
    protected function authenticate(): void
    {
        if (!$this->apiKey) {
            return;
        }

        if ($this->jwt && $this->jwt->isValid()) {
            return;
        }

        $data = $this->authentication->authenticate($this->apiKey);
        $this->jwt = new JWT($data->getToken(), $data->getExpiresIn());
        $this->configuration->setAccessToken($this->jwt->getToken());
        $this->setConfiguration($this->configuration);
    }

    /**
     * Set the user agent used for HTTP requests
     * @param string $userAgent
     * @return $this
     */
    public function setUserAgent(string $userAgent): static
    {
        $this->configuration->setUserAgent($userAgent);
        return $this->setConfiguration($this->configuration);
    }

    /**
     * Set the API token used for authentication.
     * This is only required to access non-public content or actions but if set will be used for all requests.
     * You can generate an API key in the {@link https://hangar.papermc.io/auth/settings/api-keys Account settings}
     * @param string|null $apiKey
     */
    public function setApiKey(?string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Search for projects
     * @param ProjectSearchOptions $options
     * @return ProjectList
     * @throws ApiException
     */
    public function getProjects(ProjectSearchOptions $options = new ProjectSearchOptions()): ProjectList
    {
        $this->authenticate();

        $result = $this->projects->getProjects($options->getPagination(),
            $options->isOrderWithRelevance(),
            $options->getSort()?->value,
            $options->getCategory()?->value,
            $options->getPlatform()?->value,
            $options->getOwner(),
            $options->getQuery(),
            $options->getLicense(),
            $options->getVersion(),
            $options->getTag(),
        );

        return new ProjectList($this, $result, $options);
    }

    /**
     * Get a single project
     * @param string $author
     * @param string $name
     * @return Project
     * @throws ApiException
     */
    public function getProject(string $author, string $name): Project
    {
        $this->authenticate();

        $result = $this->projects->getProject($author, $name);
        return new Project($this, $result);
    }

    /**
     * Get a list of people watching a project
     * @param ProjectNamespace $namespace
     * @param RequestPagination|null $pagination
     * @return ProjectWatcherList
     * @throws ApiException
     */
    public function getProjectWatchers(ProjectNamespace $namespace, ?RequestPagination $pagination = null): ProjectWatcherList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->projects->getProjectWatchers($namespace->getOwner(), $namespace->getSlug(), $pagination);
        return new ProjectWatcherList(
            $this,
            $result,
            $namespace,
            $pagination,
        );
    }

    /**
     * Get a list of daily project stats
     * defaults to only returning the stats for today
     * @param ProjectNamespace $namespace
     * @param DateTime|null $from
     * @param DateTime|null $to
     * @return DayProjectStats[]
     * @throws ApiException
     */
    public function getProjectDayStats(ProjectNamespace $namespace, ?DateTime $from = null, ?DateTime $to = null): array
    {
        $this->authenticate();

        $from ??= new DateTime();
        $to ??= new DateTime();
        return $this->projects->showProjectStats($namespace->getOwner(), $namespace->getSlug(), $from, $to);
    }

    /**
     * Get a list of people starring a project
     * @param ProjectNamespace $namespace
     * @param RequestPagination|null $pagination
     * @return ProjectStarGazersList
     * @throws ApiException
     */
    public function getProjectStarGazers(ProjectNamespace $namespace, ?RequestPagination $pagination = null): ProjectStarGazersList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->projects->getProjectStarGazers($namespace->getOwner(), $namespace->getSlug(), $pagination);
        return new ProjectStarGazersList(
            $this,
            $result,
            $namespace,
            $pagination,
        );
    }

    /**
     * Get a list of members of a project
     * @param ProjectNamespace $namespace
     * @param RequestPagination|null $pagination
     * @return ProjectMemberList
     * @throws ApiException
     */
    public function getProjectMembers(ProjectNamespace $namespace, ?RequestPagination $pagination = null): ProjectMemberList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->projects->getProjectMembers($namespace->getOwner(), $namespace->getSlug(), $pagination);
        return new ProjectMemberList($this, $result, $namespace, $pagination);
    }

    /**
     * Get versions of a project
     * @param ProjectNamespace|Project $project
     * @param VersionSearchOptions $options
     * @return ProjectVersionList
     * @throws ApiException
     */
    public function getProjectVersions(
        ProjectNamespace|Project $project,
        VersionSearchOptions     $options,
    ): ProjectVersionList
    {
        $this->authenticate();

        if ($project instanceof Project) {
            $options->setProject($project);
        } else {
            $options->setProjectNamespace($project);
        }

        $result = $this->versions->listVersions(
            $options->getProjectNamespace()->getOwner(),
            $options->getProjectNamespace()->getSlug(),
            $options->getPagination(),
            $options->getChannel(),
            $options->getPlatform()?->value,
            $options->getPlatformVersion(),
        );

        return new ProjectVersionList($this, $result, $options);
    }

    /**
     * Get a single project version
     * @param ProjectNamespace|Project $project
     * @param string $name
     * @return Version
     * @throws ApiException
     */
    public function getProjectVersion(ProjectNamespace|Project $project, string $name): Version
    {
        $this->authenticate();

        $namespace = $project instanceof Project ? $project->getData()->getNamespace() : $project;
        $result = $this->versions->showVersion($namespace->getOwner(), $namespace->getSlug(), $name);
        return new Version(
            $this,
            $result,
            $namespace,
            $project instanceof Project ? $project : null
        );
    }

    /**
     * Get a list of daily version stats
     * defaults to only returning the stats for today
     * @param Version $version
     * @param Platform $platform
     * @param DateTime|null $from
     * @param DateTime|null $to
     * @return array
     * @throws ApiException
     */
    public function getProjectVersionDayStats(
        Version   $version,
        Platform  $platform,
        ?DateTime $from = null,
        ?DateTime $to = null
    ): array
    {
        $this->authenticate();

        $from ??= new DateTime();
        $to ??= new DateTime();

        return $this->versions->showVersionStats(
            $version->getProjectNamespace()->getOwner(),
            $version->getProjectNamespace()->getSlug(),
            $version->getData()->getName(),
            $platform->value,
            $from,
            $to,
        );
    }

    /**
     * @param UserSearchOptions $options
     * @return UserList
     * @throws ApiException
     */
    public function getUsers(UserSearchOptions $options = new UserSearchOptions()): UserList
    {
        $this->authenticate();

        $result = $this->users->showUsers($options->getQuery(), $options->getPagination(), $options->getSort()?->value);
        return new UserList(
            $this,
            $result,
            $options,
        );
    }

    /**
     * Get a single user
     * @param string $username
     * @return User
     * @throws ApiException
     */
    public function getUser(string $username): User
    {
        $this->authenticate();

        $result = $this->users->getUser($username);
        return new User($this, $result);
    }

    /**
     * Get a list of projects a user is watching
     * @param string $username
     * @param RequestPagination|null $pagination
     * @return WatchedProjectList
     * @throws ApiException
     */
    public function getProjectsWatchedByUser(string $username, ?RequestPagination $pagination = null): WatchedProjectList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->users->getUserWatching($username, $pagination);
        return new WatchedProjectList(
            $this,
            $result,
            $username,
            $pagination,
        );
    }

    /**
     * Get a list of projects a user has starred
     * @param string $username
     * @param RequestPagination|null $pagination
     * @return StarredProjectList
     * @throws ApiException
     */
    public function getProjectsStarredByUser(string $username, ?RequestPagination $pagination = null): StarredProjectList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->users->showStarred($username, $pagination);
        return new StarredProjectList(
            $this,
            $result,
            $username,
            $pagination,
        );
    }

    /**
     * Get a list of projects a user has starred
     * @param string $username
     * @param RequestPagination|null $pagination
     * @return PinnedProjectList
     * @throws ApiException
     */
    public function getProjectsPinnedByUser(string $username, ?RequestPagination $pagination = null): PinnedProjectList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->users->showStarred($username, $pagination);
        return new PinnedProjectList(
            $this,
            $result,
            $username,
            $pagination,
        );
    }

    /**
     * @param RequestPagination|null $pagination
     * @return StaffList
     * @throws ApiException
     */
    public function getStaff(?RequestPagination $pagination = null): StaffList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->users->getStaff($pagination);
        return new StaffList(
            $this,
            $result,
            $pagination,
        );
    }

    /**
     * @param RequestPagination|null $pagination
     * @return AuthorList
     * @throws ApiException
     */
    public function getAuthors(?RequestPagination $pagination = null): AuthorList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->users->getAuthors($pagination);
        return new AuthorList(
            $this,
            $result,
            $pagination,
        );
    }
}