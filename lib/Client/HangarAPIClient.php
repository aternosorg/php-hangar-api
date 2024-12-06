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
     * @param string $slug
     * @return Project
     * @throws ApiException
     */
    public function getProject(string $slug): Project
    {
        $this->authenticate();

        $result = $this->projects->getProject($slug);
        return new Project($this, $result);
    }
    // TODO: projectByVersionHash

    /**
     * Get a list of people watching a project
     * @param string $projectSlug
     * @param RequestPagination|null $pagination
     * @return ProjectWatcherList
     * @throws ApiException
     */
    public function getProjectWatchers(string $projectSlug, ?RequestPagination $pagination = null): ProjectWatcherList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->projects->getProjectWatchers($projectSlug, $pagination);
        return new ProjectWatcherList(
            $this,
            $result,
            $projectSlug,
            $pagination,
        );
    }

    /**
     * Get a list of daily project stats
     * Days without downloads/views will not be included
     *
     * Requires the is_subject_member permission
     * @param string $slug
     * @param DateTime $from
     * @param DateTime|null $to default: now
     * @return array<string, DayProjectStats>
     * @throws ApiException
     */
    public function getDailyProjectStats(string $slug, DateTime $from, ?DateTime $to = null): array
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::IS_SUBJECT_MEMBER, $slug)) {
            throw new ApiException('You need the is_subject_member permission to view project statistics');
        }

        $to ??= new DateTime();

        return $this->projects->showProjectStats(
            $slug,
            $from->format(DateTimeInterface::RFC3339),
            $to->format(DateTimeInterface::RFC3339)
        );
    }

    /**
     * Get a list of people starring a project
     * @param string $projectSlug
     * @param RequestPagination|null $pagination
     * @return ProjectStarGazersList
     * @throws ApiException
     */
    public function getProjectStarGazers(string $projectSlug, ?RequestPagination $pagination = null): ProjectStarGazersList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->projects->getProjectStarGazers($projectSlug, $pagination);
        return new ProjectStarGazersList(
            $this,
            $result,
            $projectSlug,
            $pagination,
        );
    }

    /**
     * Get a list of members of a project
     * @param string $projectSlug
     * @param RequestPagination|null $pagination
     * @return ProjectMemberList
     * @throws ApiException
     */
    public function getProjectMembers(string $projectSlug, ?RequestPagination $pagination = null): ProjectMemberList
    {
        $this->authenticate();

        $pagination ??= (new RequestPagination())
            ->setOffset(0)
            ->setLimit(25);

        $result = $this->projects->getProjectMembers($projectSlug, $pagination);
        return new ProjectMemberList($this, $result, $projectSlug, $pagination);
    }

    /**
     * Get versions of a project
     * @param string|Project $project project slug or object
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
            $options->setProjectSlug($project);
        }

        $result = $this->versions->listVersions(
            $options->getProjectSlug(),
            $options->getPagination(),
            $options->isIncludeHiddenChannels(),
            $options->getChannel(),
            $options->getPlatform()?->value,
        );

        return new ProjectVersionList($this, $result, $options);
    }

    /**
     * Get a single project version
     * @param string|Project $project project slug or object
     * @param string $name
     * @return Version
     * @throws ApiException
     */
    public function getProjectVersion(string|Project $project, string $name): Version
    {
        $this->authenticate();

        $projectSlug = $project instanceof Project ? $project->getSlug() : $project;
        $result = $this->versions->showVersion($projectSlug, $name);
        return new Version(
            $this,
            $result,
            $projectSlug,
            $project instanceof Project ? $project : null
        );
    }

    /**
     * Get a list of daily version stats
     * Days without downloads/views will not be included
     *
     * Requires the is_subject_member permission
     * @param Version $version
     * @param DateTime $from
     * @param DateTime|null $to default: now
     * @return array<string, VersionStats>
     * @throws ApiException
     */
    public function getDailyProjectVersionStats(Version $version, DateTime $from, ?DateTime $to = null): array
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::IS_SUBJECT_MEMBER, $version->getProjectSlug())) {
            throw new ApiException('You need the is_subject_member permission to view version statistics');
        }

        $to ??= new DateTime();

        return $this->versions->showVersionStats(
            $version->getProjectSlug(),
            $version->getData()->getName(),
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
     * @param string $slug
     * @return ProjectPage
     * @throws ApiException
     */
    public function getProjectMainPage(string $slug): ProjectPage
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::VIEW_PUBLIC_INFO, $slug)) {
            throw new ApiException('You need the view_public_info permission to view project pages');
        }

        return new ProjectPage(
            $this,
            $slug,
            $this->pages->getMainPage($slug),
        );
    }

    /**
     * Get a page from a project
     * Starting and trailing slashes are ignored by the Hangar API
     * Calling this with an empty path is equivalent to calling getProjectMainPage
     *
     * Requires the view_public_info permission
     * @param string $slug
     * @param string $path
     * @return ProjectPage
     * @throws ApiException
     */
    public function getProjectPage(string $slug, string $path): ProjectPage
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::VIEW_PUBLIC_INFO, $slug)) {
            throw new ApiException('You need the view_public_info permission to view project pages');
        }

        return new ProjectPage(
            $this,
            $slug,
            $this->pages->getPage($slug, $path),
        );
    }

    /**
     * Edit the main page of a project
     *
     * Requires the edit_page permission
     * @param string $slug
     * @param string $content
     * @return ProjectPage
     * @throws ApiException
     */
    public function editProjectMainPage(string $slug, string $content): ProjectPage
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::EDIT_PAGE, $slug)) {
            throw new ApiException('You need the edit_page permission to edit project pages');
        }

        $form = new StringContent();
        $form->setContent($content);
        $this->pages->editMainPage($slug, $form);

        return new ProjectPage(
            $this,
            $slug,
            $content,
        );
    }

    /**
     * Edit any page of a project
     * Starting and trailing slashes are ignored by the Hangar API
     *
     * Requires the edit_page permission
     * @param string $slug
     * @param string $path
     * @param string $content
     * @return ProjectPage
     * @throws ApiException
     */
    public function editProjectPage(string $slug, string $path, string $content): ProjectPage
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::EDIT_PAGE, $slug)) {
            throw new ApiException('You need the edit_page permission to edit project pages');
        }

        $form = new PageEditForm();
        $form->setContent($content);
        $form->setPath($path);
        $this->pages->editPage($slug, $form);

        return new ProjectPage(
            $this,
            $slug,
            $content,
            $path,
        );
    }
}