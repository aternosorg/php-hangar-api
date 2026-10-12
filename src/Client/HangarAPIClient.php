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
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSortField;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSortOrder;
use Aternos\HangarApi\Client\Options\UserSearch\AuthorSortField;
use Aternos\HangarApi\Client\Options\UserSearch\StaffSortField;
use Aternos\HangarApi\Client\Options\UserSearch\UserSearchOptions;
use Aternos\HangarApi\Client\Options\VersionSearch\VersionSearchOptions;
use Aternos\HangarApi\Configuration;
use Aternos\HangarApi\Model\DayProjectStats;
use Aternos\HangarApi\Model\NamedPermission;
use Aternos\HangarApi\Model\PageEditForm;
use Aternos\HangarApi\Model\StringContent;
use Aternos\HangarApi\Model\VersionStats;
use DateTime;
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
        ?Configuration   $configuration = null,
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
     * @param NamedPermission[] $permissions
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

        return $this->permissions->hasAll($permissions, project: $project)->getResult();
    }

    /**
     * Check if the user has a specific permission
     * @param NamedPermission $permission
     * @param string|null $project
     * @return bool
     * @throws ApiException
     */
    public function hasPermission(NamedPermission $permission, ?string $project = null): bool
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

        $result = $this->projects->getProjects(
            $options->isPrioritizeExactMatch(),
            $options->getSortParameter(),
            $options->getCategory()?->value,
            $options->getPlatform()?->value,
            $options->getOwner(),
            query: $options->getQuery(),
            license: $options->getLicense(),
            version: $options->getVersion(),
            tag: $options->getTag()?->value,
            limit: $options->getLimit(),
            offset: $options->getOffset(),
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

    /**
     * Get a single project by its version hash (SHA-256)
     * @param string $hash
     * @return Project
     * @throws ApiException
     */
    public function getProjectByVersionHash(string $hash): Project
    {
        $this->authenticate();

        $result = $this->projects->projectByVersionHash($hash);
        return new Project($this, $result);
    }

    /**
     * Get a list of people watching a project
     * @param string $slugOrId
     * @param int $limit
     * @param int $offset
     * @return ProjectWatcherList
     * @throws ApiException
     */
    public function getProjectWatchers(string $slugOrId, int $limit = 25, int $offset = 0): ProjectWatcherList
    {
        $this->authenticate();

        $result = $this->projects->getProjectWatchers($slugOrId, $limit, $offset);
        return new ProjectWatcherList(
            $this,
            $result,
            $slugOrId,
            $limit,
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
            $from,
            $to,
        );
    }

    /**
     * Get a list of people starring a project
     * @param string $slugOrId
     * @param int $limit
     * @param int $offset
     * @return ProjectStarGazersList
     * @throws ApiException
     */
    public function getProjectStarGazers(string $slugOrId, int $limit = 25, int $offset = 0): ProjectStarGazersList
    {
        $this->authenticate();

        $result = $this->projects->getProjectStargazers($slugOrId, $limit, $offset);
        return new ProjectStarGazersList(
            $this,
            $result,
            $slugOrId,
            $limit,
        );
    }

    /**
     * Get a list of members of a project
     * @param string $slugOrId
     * @param int $limit
     * @param int $offset
     * @return ProjectMemberList
     * @throws ApiException
     */
    public function getProjectMembers(string $slugOrId, int $limit = 25, int $offset = 0): ProjectMemberList
    {
        $this->authenticate();

        $result = $this->projects->getProjectMembers($slugOrId, $limit, $offset);
        return new ProjectMemberList($this, $result, $slugOrId, $limit);
    }

    /**
     * Get versions of a project
     * @param string|Project $project project slug, id or object
     * @param VersionSearchOptions $options
     * @return ProjectVersionList
     * @throws ApiException
     */
    public function getProjectVersions(
        string|Project       $project,
        VersionSearchOptions $options,
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
            $options->isIncludeHiddenChannels(),
            $options->getChannel(),
            $options->getPlatform()?->value,
            limit: $options->getLimit(),
            offset: $options->getOffset(),
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

        $result = $this->versions->showVersionById((string)$versionId);
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
            $from,
            $to,
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

        $to ??= new DateTime();

        return $this->versions->showVersionStatsById(
            (string)$versionId,
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

        $result = $this->users->showUsers(
            $options->getQuery(),
            $options->getSort()?->value,
            limit: $options->getLimit(),
            offset: $options->getOffset(),
        );
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
     * Note: The Hangar API currently responds with HTTP 500 when sorting by {@see ProjectSortField::UPDATED}
     * @param ProjectSortField|null $sortField Optional field to sort the results by
     * @param ProjectSortOrder $sortOrder
     * @param int $limit
     * @param int $offset
     * @return WatchedProjectList
     * @throws ApiException
     */
    public function getProjectsWatchedByUser(
        string            $username,
        ?ProjectSortField $sortField = null,
        ProjectSortOrder  $sortOrder = ProjectSortOrder::ASC,
        int               $limit = 25,
        int               $offset = 0,
    ): WatchedProjectList
    {
        $this->authenticate();

        $result = $this->users->getUserWatching(
            $username,
            $sortField?->getSortParameter($sortOrder),
            $limit,
            $offset,
        );
        return new WatchedProjectList(
            $this,
            $result,
            $username,
            $sortField,
            $sortOrder,
            $limit,
        );
    }

    /**
     * Get a list of projects a user has starred
     * @param string $username
     * Note: The Hangar API currently responds with HTTP 500 when sorting by {@see ProjectSortField::UPDATED}
     * @param ProjectSortField|null $sortField Optional field to sort the results by
     * @param ProjectSortOrder $sortOrder
     * @param int $limit
     * @param int $offset
     * @return StarredProjectList
     * @throws ApiException
     */
    public function getProjectsStarredByUser(
        string            $username,
        ?ProjectSortField $sortField = null,
        ProjectSortOrder  $sortOrder = ProjectSortOrder::ASC,
        int               $limit = 25,
        int               $offset = 0,
    ): StarredProjectList
    {
        $this->authenticate();

        $result = $this->users->showStarred(
            $username,
            $sortField?->getSortParameter($sortOrder),
            $limit,
            $offset,
        );
        return new StarredProjectList(
            $this,
            $result,
            $username,
            $sortField,
            $sortOrder,
            $limit,
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
     * @param StaffSortField|null $sort Optional field to sort the results by
     * @param int $limit
     * @param int $offset
     * @return StaffList
     * @throws ApiException
     */
    public function getStaff(string $query = "", ?StaffSortField $sort = null, int $limit = 25, int $offset = 0): StaffList
    {
        $this->authenticate();

        if (!$this->hasPermission(NamedPermission::VIEW_PUBLIC_INFO)) {
            throw new ApiException('You need the view_public_info permission to view staff');
        }

        $result = $this->users->getStaff($query, $sort?->value, $limit, $offset);
        return new StaffList(
            $this,
            $result,
            $query,
            $sort,
            $limit,
        );
    }

    /**
     * Search the API for project authors matching the search query
     * @param string $query Search query. Default: "" (all)
     * @param AuthorSortField|null $sort Optional field to sort the results by
     * @param int $limit
     * @param int $offset
     * @return AuthorList
     * @throws ApiException
     */
    public function getAuthors(string $query = "", ?AuthorSortField $sort = null, int $limit = 25, int $offset = 0): AuthorList
    {
        $this->authenticate();

        $result = $this->users->getAuthors($query, $sort?->value, $limit, $offset);
        return new AuthorList(
            $this,
            $result,
            $query,
            $sort,
            $limit,
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
