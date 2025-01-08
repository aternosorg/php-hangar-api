<?php

namespace Aternos\HangarApi\Client;

use Aternos\HangarApi\Api\AuthenticationApi;
use Aternos\HangarApi\Api\PagesApi;
use Aternos\HangarApi\Api\PermissionsApi;
use Aternos\HangarApi\Api\ProjectsApi;
use Aternos\HangarApi\Api\UsersApi;
use Aternos\HangarApi\Api\VersionsApi;
use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\List\CompactProject\StarredProjectList;
use Aternos\HangarApi\Client\List\CompactProject\WatchedProjectList;
use Aternos\HangarApi\Client\List\ProjectList;
use Aternos\HangarApi\Client\List\ProjectMemberList;
use Aternos\HangarApi\Client\List\ProjectVersionList;
use Aternos\HangarApi\Client\List\User\AuthorList;
use Aternos\HangarApi\Client\List\User\ProjectStarGazersList;
use Aternos\HangarApi\Client\List\User\ProjectWatcherList;
use Aternos\HangarApi\Client\List\User\StaffList;
use Aternos\HangarApi\Client\List\UserList;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
use Aternos\HangarApi\Client\Options\UserSearch\UserSearchOptions;
use Aternos\HangarApi\Client\Options\VersionSearch\VersionSearchOptions;
use Aternos\HangarApi\Configuration;
use Aternos\HangarApi\Model\DayProjectStats;
use Aternos\HangarApi\Model\NamedPermission;
use Aternos\HangarApi\Model\PageEditForm;
use Aternos\HangarApi\Model\RequestPagination;
use Aternos\HangarApi\Model\StringContent;
use Aternos\HangarApi\Model\VersionStats;
use DateTime;
use DateTimeInterface;
use GuzzleHttp\ClientInterface;

/**
 * Class HangarAPIClient
 *
 * @package Aternos\HangarApi\Client
 * @description This class is the main entry point for the hangar api. It provides methods to access all hangar api endpoints.
 */
class HangarAPIClient
{

    protected Configuration $configuration;

    protected ?string $apiKey = null;

    protected ?JWT $jwt = null;

    protected ?ClientInterface $httpClient;

    protected ProjectsApi $projects;

    protected VersionsApi $versions;

    protected UsersApi $users;

    protected AuthenticationApi $authentication;

    protected PermissionsApi $permissions;

    protected PagesApi $pages;

    public function __construct(
        Configuration    $configuration = null,
        ?string          $apiKey = null,
        ?ClientInterface $httpClient = null,
        ?string          $userAgent = null,
    )
    {
        $this->apiKey = $apiKey;
        $this->httpClient = $httpClient;
        $this->setConfiguration($configuration ?? (new Configuration())
            ->setUserAgent($userAgent ?? "php-hangar-api/2.0.0"));
    }

    /**
     * @param Configuration $configuration
     * @return $this
     */
    public function setConfiguration(Configuration $configuration): static
    {
        $this->configuration = $configuration;
        $this->projects = new ProjectsApi($this->httpClient, $this->configuration);
        $this->versions = new VersionsApi($this->httpClient, $this->configuration);
        $this->users = new UsersApi($this->httpClient, $this->configuration);
        $this->authentication = new AuthenticationApi($this->httpClient, $this->configuration);
        $this->permissions = new PermissionsApi($this->httpClient, $this->configuration);
        $this->pages = new PagesApi($this->httpClient, $this->configuration);
        return $this;
    }

    /**
     * @throws ApiException
     */
    protected function authenticate(): bool
    {
        if (!$this->apiKey) {
            return false;
        }

        if ($this->jwt && $this->jwt->isValid()) {
            return true;
        }

        $data = $this->authentication->authenticate($this->apiKey);
        $this->jwt = new JWT($data->getToken(), $data->getExpiresIn());
        $this->configuration->setAccessToken($this->jwt->getToken());
        $this->setConfiguration($this->configuration);
        return true;
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
     * @return $this
     */
    public function setApiKey(?string $apiKey): static
    {
        $this->apiKey = $apiKey;
        $this->jwt = null;
        return $this;
    }

    /**
     * Set the HTTP client used for all requests.
     * When null, the default HTTP client from Guzzle will be used.
     * @param ClientInterface|null $httpClient
     * @return $this
     */
    public function setHttpClient(?ClientInterface $httpClient): static
    {
        $this->httpClient = $httpClient;
        return $this->setConfiguration($this->configuration);
    }

    /**
     * Check if the user has all the given permissions for a project
     * @param string[] $permissions (value of {@see NamedPermission})
     * @param string|null $project
     * @return bool
     * @throws ApiException
     */
    public function hasPermissions(array $permissions, ?string $project = null): bool
    {
        if (!$this->authenticate()) {
            return sizeof($permissions) === 0 || sizeof($permissions) === 1 &&
                $permissions[0] === NamedPermission::VIEW_PUBLIC_INFO;
        }

        return $this->permissions->hasAll($permissions, $project)->getResult();
    }

    /**
     * Check if the user has a specific permission
     * @param string $permission (value of {@see NamedPermission})
     * @param string|null $project
     * @return bool
     * @throws ApiException
     */
    public function hasPermission(string $permission, ?string $project = null): bool
    {
        return $this->hasPermissions([$permission], $project);
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
            $options->isPrioritizeExactMatch(),
            $options->getSortParameter(),
            $options->getCategory()?->value,
            $options->getPlatform()?->value,
            $options->getOwner(),
            $options->getQuery(),
            null,
            $options->getLicense(),
            $options->getVersion(),
            $options->getTag()?->value,
        );

        return new ProjectList($this, $result, $options);
    }

    /**
     * Get a single project
     * @param string $slugOrId
     * @return Project
     * @throws ApiException
     */
    public function getProject(string $slugOrId): Project
    {
        $this->authenticate();

        $result = $this->projects->getProject($slugOrId);
        return new Project($this, $result);
    }
    // TODO: projectByVersionHash

    /**
     * Get a list of people watching a project
     * @param string $slugOrId
     * @param RequestPagination|null $pagination
     * @return ProjectWatcherList
     * @throws ApiException
     */
    public function getProjectWatchers(string $slugOrId, ?RequestPagination $pagination = null): ProjectWatcherList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->projects->getProjectWatchers($slugOrId, $pagination);
        return new ProjectWatcherList(
            $this,
            $result,
            $slugOrId,
            $pagination,
        );
    }

    /**
     * Get a list of daily project stats
     * Days without downloads/views will not be included
     *
     * Requires the is_subject_member permission
     * @param string $slugOrId
     * @param DateTime $from
     * @param DateTime|null $to default: now
     * @return array<string, DayProjectStats>
     * @throws ApiException
     */
    public function getDailyProjectStats(string $slugOrId, DateTime $from, ?DateTime $to = null): array
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::IS_SUBJECT_MEMBER, $slugOrId)) {
            throw new ApiException('You need the is_subject_member permission to view project statistics');
        }

        $to ??= new DateTime();

        return $this->projects->showProjectStats(
            $slugOrId,
            $from->format(DateTimeInterface::RFC3339),
            $to->format(DateTimeInterface::RFC3339)
        );
    }

    /**
     * Get a list of people starring a project
     * @param string $slugOrId
     * @param RequestPagination|null $pagination
     * @return ProjectStarGazersList
     * @throws ApiException
     */
    public function getProjectStarGazers(string $slugOrId, ?RequestPagination $pagination = null): ProjectStarGazersList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->projects->getProjectStarGazers($slugOrId, $pagination);
        return new ProjectStarGazersList(
            $this,
            $result,
            $slugOrId,
            $pagination,
        );
    }

    /**
     * Get a list of members of a project
     * @param string $slugOrId
     * @param RequestPagination|null $pagination
     * @return ProjectMemberList
     * @throws ApiException
     */
    public function getProjectMembers(string $slugOrId, ?RequestPagination $pagination = null): ProjectMemberList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->projects->getProjectMembers($slugOrId, $pagination);
        return new ProjectMemberList($this, $result, $slugOrId, $pagination);
    }

    /**
     * Get versions of a project
     * @param string|Project $project project slug, id or object
     * @param VersionSearchOptions $options
     * @return ProjectVersionList
     * @throws ApiException
     */
    public function getProjectVersions(
        string|Project $project,
        VersionSearchOptions     $options,
    ): ProjectVersionList
    {
        $this->authenticate();

        if ($project instanceof Project) {
            $options->setProject($project);
        } else {
            $options->setProjectSlugOrId($project);
        }

        $result = $this->versions->listVersions(
            $options->getProjectSlugOrId(),
            $options->getPagination(),
            $options->isIncludeHiddenChannels(),
            $options->getChannel(),
            $options->getPlatform()?->value,
        );

        return new ProjectVersionList($this, $result, $options);
    }

    /**
     * Get the latest release version of a project
     * @param string $projectSlugOrId
     * @return string
     * @throws ApiException
     */
    public function getLatestReleaseVersion(string $projectSlugOrId): string
    {
        $this->authenticate();

        return $this->versions->latestReleaseVersion($projectSlugOrId);
    }

    /**
     * Get the latest version of a project in a specific channel
     * @param string $projectSlugOrId
     * @param string $channel
     * @return string
     * @throws ApiException
     */
    public function getLatestVersion(string $projectSlugOrId, string $channel): string
    {
        $this->authenticate();

        return $this->versions->latestVersion($projectSlugOrId, $channel);
    }


    /**
     * Get a single project version using the project and version name or id
     * @param string|Project $project project slug, id or object
     * @param string $nameOrId version name or id
     * @return Version
     * @throws ApiException
     */
    public function getVersion(string|Project $project, string $nameOrId): Version
    {
        $this->authenticate();

        $slugOrId = $project instanceof Project ? $project->getId() : $project;
        $result = $this->versions->showVersion($slugOrId, $nameOrId);
        return new Version(
            $this,
            $result,
            $slugOrId,
            $project instanceof Project ? $project : null
        );
    }

    /**
     * Get a single project version without specifying the project
     * To use this method you need to specify the version id. If you only have the version name, use {@see getVersion}
     * @param int $versionId version id
     * @return Version
     * @throws ApiException
     */
    public function getVersionById(int $versionId): Version
    {
        $this->authenticate();

        $result = $this->versions->showVersionById($versionId);
        return new Version(
            $this,
            $result,
            $versionId,
        );
    }

    /**
     * Get a list of daily version stats
     * Days without downloads/views will not be included
     *
     * Requires the is_subject_member permission
     * @param string $projectSlugOrId
     * @param string $versionNameOrId
     * @param DateTime $from
     * @param DateTime|null $to default: now
     * @return array<string, VersionStats>
     * @throws ApiException
     */
    public function getDailyVersionStats(string $projectSlugOrId, string $versionNameOrId, DateTime $from, ?DateTime $to = null): array
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::IS_SUBJECT_MEMBER, $projectSlugOrId)) {
            throw new ApiException('You need the is_subject_member permission to view version statistics');
        }

        $to ??= new DateTime();

        return $this->versions->showVersionStats(
            $projectSlugOrId,
            $versionNameOrId,
            $from->format(DateTimeInterface::RFC3339),
            $to->format(DateTimeInterface::RFC3339),
        );
    }

    /**
     * Get a list of daily version stats
     * Days without downloads/views will not be included
     *
     * To use this method you need to specify the version id. If you only have the version name, use {@see getDailyVersionStats}
     *
     * Requires the is_subject_member permission
     * @param int $versionId version id
     * @return array<string, VersionStats>
     * @throws ApiException
     */
    public function getDailyVersionStatsById(int $versionId, DateTime $from, ?DateTime $to = null): array
    {
        $this->authenticate();

        return $this->versions->showVersionStatsById(
            $versionId,
            $from->format(DateTimeInterface::RFC3339),
            $to->format(DateTimeInterface::RFC3339),
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
     *
     * Requires the view_public_info permission
     * @param string $username
     * @return User
     * @throws ApiException
     */
    public function getUser(string $username): User
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::VIEW_PUBLIC_INFO)) {
            throw new ApiException('You need the view_public_info permission to view users');
        }

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
     * @return CompactProject[]
     * @throws ApiException
     */
    public function getProjectsPinnedByUser(string $username): array
    {
        $this->authenticate();

        $result = $this->users->getUserPinnedProjects($username);
        return array_map(
            fn($project) => new CompactProject($this, $project),
            $result,
        );
    }

    /**
     * Get a list of hangar staff
     *
     * Requires the view_public_info permission
     * @param string $query Search query. Default: "" (all)
     * @param RequestPagination|null $pagination
     * @param string|null $sort Optional name of the field to sort the results by
     * @return StaffList
     * @throws ApiException
     */
    public function getStaff(string $query = "", ?RequestPagination $pagination = null, ?string $sort = null): StaffList
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::VIEW_PUBLIC_INFO)) {
            throw new ApiException('You need the view_public_info permission to view staff');
        }

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->users->getStaff($query, $pagination, $sort);
        return new StaffList(
            $this,
            $result,
            $pagination,
            $query,
            $sort
        );
    }

    /**
     * Search the API for project authors matching the search query
     * @param string $query Search query. Default: "" (all)
     * @param RequestPagination|null $pagination
     * @param string|null $sort Optional name of the field to sort the results by
     * @return AuthorList
     * @throws ApiException
     */
    public function getAuthors(string $query = "", ?RequestPagination $pagination = null, ?string $sort = null): AuthorList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->users->getAuthors($query, $pagination);
        return new AuthorList(
            $this,
            $result,
            $pagination,
            $query,
            $sort
        );
    }

    /**
     * Get the main page of a project
     *
     * Requires the view_public_info permission
     * @param string $projectSlugOrId
     * @return ProjectPage
     * @throws ApiException
     */
    public function getProjectMainPage(string $projectSlugOrId): ProjectPage
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::VIEW_PUBLIC_INFO, $projectSlugOrId)) {
            throw new ApiException('You need the view_public_info permission to view project pages');
        }

        return new ProjectPage(
            $this,
            $projectSlugOrId,
            $this->pages->getMainPage($projectSlugOrId),
        );
    }

    /**
     * Get a page from a project
     * Starting and trailing slashes are ignored by the Hangar API
     * Calling this with an empty path is equivalent to calling getProjectMainPage
     *
     * Requires the view_public_info permission
     * @param string $projectSlugOrId
     * @param string $path
     * @return ProjectPage
     * @throws ApiException
     */
    public function getProjectPage(string $projectSlugOrId, string $path): ProjectPage
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::VIEW_PUBLIC_INFO, $projectSlugOrId)) {
            throw new ApiException('You need the view_public_info permission to view project pages');
        }

        return new ProjectPage(
            $this,
            $projectSlugOrId,
            $this->pages->getPage($projectSlugOrId, $path),
        );
    }

    /**
     * Edit the main page of a project
     *
     * Requires the edit_page permission
     * @param string $projectSlugOrId
     * @param string $content
     * @return ProjectPage
     * @throws ApiException
     */
    public function editProjectMainPage(string $projectSlugOrId, string $content): ProjectPage
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::EDIT_PAGE, $projectSlugOrId)) {
            throw new ApiException('You need the edit_page permission to edit project pages');
        }

        $form = new StringContent();
        $form->setContent($content);
        $this->pages->editMainPage($projectSlugOrId, $form);

        return new ProjectPage(
            $this,
            $projectSlugOrId,
            $content,
        );
    }

    /**
     * Edit any page of a project
     * Starting and trailing slashes are ignored by the Hangar API
     *
     * Requires the edit_page permission
     * @param string $projectSlugOrId
     * @param string $path
     * @param string $content
     * @return ProjectPage
     * @throws ApiException
     */
    public function editProjectPage(string $projectSlugOrId, string $path, string $content): ProjectPage
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::EDIT_PAGE, $projectSlugOrId)) {
            throw new ApiException('You need the edit_page permission to edit project pages');
        }

        $form = new PageEditForm();
        $form->setContent($content);
        $form->setPath($path);
        $this->pages->editPage($projectSlugOrId, $form);

        return new ProjectPage(
            $this,
            $projectSlugOrId,
            $content,
            $path,
        );
    }
}
