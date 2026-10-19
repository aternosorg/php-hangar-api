<?php

namespace Aternos\HangarApi\Tests\Integration\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\ResultList;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSortField;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSortOrder;
use Aternos\HangarApi\Client\Options\UserSearch\AuthorSortField;
use Aternos\HangarApi\Client\Options\UserSearch\StaffSortField;
use Aternos\HangarApi\Model\Category;
use Aternos\HangarApi\Model\ProjectNamespace;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    protected ?HangarAPIClient $apiClient = null;

    /**
     * Setup before running any test cases
     */
    public static function setUpBeforeClass(): void
    {
    }

    /**
     * Setup before running each test case
     */
    public function setUp(): void
    {
        $this->apiClient = new HangarAPIClient();
        $this->apiClient->setUserAgent(HangarAPIClient::getDefaultUserAgent() . " (contact@aternos.org)");
        $this->apiClient->setApiKey(getenv("HANGAR_API_KEY"));
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown(): void
    {
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass(): void
    {
    }

    protected function assertValidNamespace($namespace): void
    {
        $this->assertNotNull($namespace);
        $this->assertInstanceOf(ProjectNamespace::class, $namespace);
        $this->assertNotNull($namespace->getOwner());
        $this->assertNotNull($namespace->getSlug());
    }

    protected function assertValidProject($project): void
    {
        $this->assertNotNull($project);
        $this->assertValidNamespace($project->getNamespace());
        $this->assertNotNull($project->getName());
        $this->assertNotNull($project->getStats());
        $this->assertNotNull($project->getStats()->getViews());
        $this->assertNotNull($project->getStats()->getDownloads());
        $this->assertNotNull($project->getStats()->getRecentViews());
        $this->assertNotNull($project->getStats()->getRecentDownloads());
        $this->assertNotNull($project->getStats()->getStars());
        $this->assertNotNull($project->getStats()->getWatchers());
        $this->assertNotNull($project->getCategory());
        $this->assertNotSame(Category::UNKNOWN_DEFAULT_OPEN_API, $project->getCategory());
        $this->assertNotNull($project->getLastUpdated());
        $this->assertNotNull($project->getVisibility());
        $this->assertNotNull($project->getDescription());
        $this->assertNotNull($project->getSettings());
    }

    protected function assertValidCompactProject($project): void
    {
        $this->assertNotNull($project);
        $this->assertValidNamespace($project->getNamespace());
        $this->assertNotNull($project->getName());
        $this->assertNotNull($project->getStats());
        $this->assertNotNull($project->getStats()->getViews());
        $this->assertNotNull($project->getStats()->getDownloads());
        $this->assertNotNull($project->getStats()->getRecentViews());
        $this->assertNotNull($project->getStats()->getRecentDownloads());
        $this->assertNotNull($project->getStats()->getStars());
        $this->assertNotNull($project->getStats()->getWatchers());
        $this->assertNotNull($project->getCategory());
        $this->assertNotSame(Category::UNKNOWN_DEFAULT_OPEN_API, $project->getCategory());
        $this->assertNotNull($project->getLastUpdated());
        $this->assertNotNull($project->getVisibility());
    }

    protected function assertValidResultList($list): void
    {
        $this->assertNotNull($list);
        $this->assertInstanceOf(ResultList::class, $list);
        $this->assertNotEmpty($list);
        $this->assertNotNull($list->getResults());
        $this->assertNotEmpty($list->getResults());
    }

    protected function isSameProject($a, $b): bool
    {
        if (!$a?->getNamespace()?->getOwner() || !$b?->getNamespace()?->getOwner()) {
            return false;
        }

        if (!$a?->getNamespace()?->getSlug() || !$b?->getNamespace()?->getSlug()) {
            return false;
        }

        if ($a->getNamespace()->getOwner() !== $b->getNamespace()->getOwner()) {
            return false;
        }

        if ($a->getNamespace()->getSlug() !== $b->getNamespace()->getSlug()) {
            return false;
        }

        return true;
    }


    /**
     * Test case for getProjects
     * @throws ApiException
     */
    public function testGetProjects(): void
    {
        $projectList = $this->apiClient->getProjects();
        $this->assertFalse($projectList->hasPreviousPage());

        $firstProjectOfPages = [];
        for ($i = 0; $i < 3; $i++) {
            $this->assertValidResultList($projectList);
            $firstProjectOfPages[$i] = $projectList[0];

            foreach ($projectList as $project) {
                $this->assertValidProject($project);
            }

            $this->assertTrue($projectList->hasNextPage());
            $projectList = $projectList->getNextPage();
        }

        for ($i = 2; $i >= 0; $i--) {
            $this->assertTrue($projectList->hasPreviousPage());
            $projectList = $projectList->getPreviousPage();

            $this->assertValidResultList($projectList);
            $this->assertTrue($this->isSameProject($firstProjectOfPages[$i], $projectList[0]));

            foreach ($projectList as $project) {
                $this->assertValidProject($project);
            }
            $this->assertTrue($projectList->hasNextPage());
        }
        $this->assertFalse($projectList->hasPreviousPage());
    }

    /**
     * Test case for getProjects with a specified category
     * @throws ApiException
     */
    public function testGetProjectsInCategory(): void
    {
        $options = new ProjectSearchOptions();
        $options->setCategory(Category::ADMIN_TOOLS);
        $options->setLimit(10);
        $projectList = $this->apiClient->getProjects($options);
        $this->assertFalse($projectList->hasPreviousPage());

        $firstProjectOfPages = [];
        for ($i = 0; $i < 3; $i++) {
            $this->assertValidResultList($projectList);
            $firstProjectOfPages[$i] = $projectList[0];

            foreach ($projectList as $project) {
                $this->assertValidProject($project);
                $this->assertSame(Category::ADMIN_TOOLS, $project->getCategory());
            }

            $this->assertTrue($projectList->hasNextPage());
            $projectList = $projectList->getNextPage();
        }

        for ($i = 2; $i >= 0; $i--) {
            $this->assertTrue($projectList->hasPreviousPage());
            $projectList = $projectList->getPreviousPage();

            $this->assertValidResultList($projectList);
            $this->assertTrue($this->isSameProject($firstProjectOfPages[$i], $projectList[0]));

            foreach ($projectList as $project) {
                $this->assertValidProject($project);
                $this->assertSame(Category::ADMIN_TOOLS, $project->getCategory());
            }
            $this->assertTrue($projectList->hasNextPage());
        }
        $this->assertFalse($projectList->hasPreviousPage());
    }

    /**
     * Test case for getProjects with a specified owner
     * @throws ApiException
     */
    public function testGetProjectsByOwner(): void
    {
        $options = new ProjectSearchOptions();
        $options->setOwner("Aternos");
        $options->setLimit(10);
        $projectList = $this->apiClient->getProjects($options);
        $this->assertValidResultList($projectList);

        foreach ($projectList as $project) {
            $this->assertValidProject($project);
            $this->assertEquals("Aternos", $project->getNamespace()->getOwner());
        }

        $this->assertEquals(2, $projectList->getPagination()->getCount());
        $this->assertFalse($projectList->hasNextPage());
        $projectList = $projectList->getNextPage();
        $this->assertNull($projectList);
    }

    /**
     * Test case for getProjects sorting by the shortest duration since the last update
     * @throws ApiException
     */
    public function testGetRecentlyUpdatedProjects(): void
    {
        $options = new ProjectSearchOptions();
        $options->setLimit(10);
        $options->setSortField(ProjectSortField::UPDATED);
        $options->setSortOrder(ProjectSortOrder::DESC);
        $projectList = $this->apiClient->getProjects($options);
        $this->assertValidResultList($projectList);

        $lastUpdated = time();
        foreach ($projectList as $project) {
            $this->assertValidProject($project);
            $updated = $project->getLastUpdated()->getTimestamp();
            $this->assertLessThanOrEqual($lastUpdated, $updated);
            $lastUpdated = $updated;
        }
    }

    /**
     * Test case for getProjects sorting by the longest duration since the last update
     * @throws ApiException
     */
    public function testGetNotRecentlyUpdatedProjects(): void
    {
        $options = new ProjectSearchOptions();
        $options->setLimit(10);
        $options->setSortField(ProjectSortField::UPDATED);
        $options->setSortOrder(ProjectSortOrder::ASC);
        $projectList = $this->apiClient->getProjects($options);
        $this->assertValidResultList($projectList);

        $lastUpdated = 0;
        foreach ($projectList as $project) {
            $this->assertValidProject($project);
            $updated = $project->getLastUpdated()->getTimestamp();
            $this->assertGreaterThanOrEqual($lastUpdated, $updated);
            $lastUpdated = $updated;
        }
    }

    /**
     * Test case for getProjects sorting by slug
     * @throws ApiException
     */
    public function testGetProjectsSortedBySlug(): void
    {
        $options = new ProjectSearchOptions();
        $options->setLimit(10);
        $options->setSortField(ProjectSortField::SLUG);
        $options->setSortOrder(ProjectSortOrder::ASC);
        $projectList = $this->apiClient->getProjects($options);
        $this->assertValidResultList($projectList);

        $lastSlug = null;
        foreach ($projectList as $project) {
            $this->assertValidProject($project);
            $slug = $project->getSlug();
            if ($lastSlug !== null) {
                $this->assertLessThanOrEqual(0, strcasecmp($lastSlug, $slug));
            }
            $lastSlug = $slug;
        }
    }

    /**
     * All combinations of project sort fields and sort orders
     * @return array<string, array{ProjectSortField, ProjectSortOrder}>
     */
    public static function projectSortProvider(): array
    {
        $data = [];
        foreach (ProjectSortField::cases() as $sortField) {
            foreach (ProjectSortOrder::cases() as $sortOrder) {
                $data[$sortField->name . " " . $sortOrder->name] = [$sortField, $sortOrder];
            }
        }
        return $data;
    }

    /**
     * Test that the API accepts a sort field in a sort order
     * @throws ApiException
     */
    #[DataProvider('projectSortProvider')]
    public function testProjectSortIsSupported(ProjectSortField $sortField, ProjectSortOrder $sortOrder): void
    {
        $options = new ProjectSearchOptions();
        $options->setLimit(1);
        $options->setSortField($sortField);
        $options->setSortOrder($sortOrder);
        $projectList = $this->apiClient->getProjects($options);
        $this->assertValidResultList($projectList);
    }

    /**
     * Test case for getProject
     * @throws ApiException
     */
    public function testGetProject(): void
    {
        $project = $this->apiClient->getProject("mclogs");
        $this->assertNotNull($project);
        $this->assertValidProject($project);
        $this->assertEquals("Aternos", $project->getNamespace()->getOwner());

        $versions = $project->fetchVersions();
        $this->assertNotNull($versions);
        $this->assertNotEmpty($versions);
        foreach ($versions as $version) {
            $this->assertEquals($project, $version->fetchProject());
            $fetched = $project->fetchVersion($version->getName());
            $this->assertEquals($version->getName(), $fetched->getName());
        }
    }

    /**
     * Test case for fetching members of a project
     * @throws ApiException
     */
    public function testGetProjectMembers(): void
    {
        $project = $this->apiClient->getProject("motdgg");
        $this->assertNotNull($project);
        $this->assertValidProject($project);
        $this->assertEquals("Aternos", $project->getNamespace()->getOwner());

        $members = $project->fetchMembers();
        $this->assertValidResultList($members);
        $this->assertNotEmpty(array_filter($members->getResults(), function ($member) {
            return $member->getUser() === "Aternos";
        }));
    }

    /**
     * Test case for fetching users watching a project
     * @throws ApiException
     */
    public function testGetProjectWatchers(): void
    {
        $project = $this->apiClient->getProject("motdgg");
        $this->assertNotNull($project);
        $this->assertValidProject($project);
        $this->assertEquals("Aternos", $project->getNamespace()->getOwner());

        $watchers = $project->fetchWatchers();
        $this->assertValidResultList($watchers);
        $this->assertNotEmpty(array_filter($watchers->getResults(), function ($watcher) {
            return $watcher->getName() === "Julian";
        }));

        foreach ($watchers as $watcher) {
            $projects = $watcher->fetchWatchedProjects();
            $this->assertValidResultList($projects);

            if ($projects->hasNextPage()) {
                // let's ignore people watching hundreds of projects to not spam the api
                continue;
            }

            $this->assertNotEmpty(array_filter($projects->getResults(), function ($watchedProject) use ($project) {
                return $this->isSameProject($watchedProject, $project);
            }));
        }
    }

    /**
     * Test case for fetching project day stats
     * @throws ApiException
     */
    public function testGetDailyProjectStats(): void
    {
        if (!getenv("HANGAR_API_KEY")) {
            $this->markTestSkipped("This test requires authentication.");
            // no API key provided will result in a 403 Forbidden error:
            // You need the is_subject_member permission to view project statistics
        }

        $project = $this->apiClient->getProject("mclogs");
        $this->assertNotNull($project);
        $this->assertValidProject($project);

        $stats = $project->fetchDailyStats();
        $this->assertNotNull($stats);
        $this->assertNotEmpty($stats);

        foreach ($stats as $day => $stat) {
            $this->assertNotNull($day);
            $this->assertNotNull($stat);
            $this->assertNotNull($stat->getDownloads());
            $this->assertNotNull($stat->getViews());
        }
    }

    /**
     * Test case for fetching project day stats
     * This is currently broken because hangar returns an HTTP 500 error: https://github.com/HangarMC/Hangar/issues/1140
     * @throws ApiException
     */
    public function testGetDailyProjectVersionStats(): void
    {
        if (!getenv("HANGAR_API_KEY")) {
            $this->markTestSkipped("This test requires authentication.");
        }

        $project = $this->apiClient->getProject("mclogs");
        $this->assertNotNull($project);
        $this->assertValidProject($project);

        $versions = $project->fetchVersions();
        $this->assertValidResultList($versions);
        foreach ($versions as $version) {
            foreach ($version->getStats()->getPlatformDownloads() as $downloads) {
                if ($downloads > 0) {
                    $stats = $version->fetchDailyStats();
                    $this->assertNotNull($stats);
                    $this->assertNotEmpty($stats);

                    foreach ($stats as $day => $stat) {
                        $this->assertNotNull($day);
                        $this->assertNotNull($stat);
                        $this->assertNotNull($stat->getTotalDownloads());
                        $this->assertNotNull($stat->getPlatformDownloads());
                    }
                    break 2;
                }
            }
        }
    }

    /**
     * Test case for getUsers
     * @throws ApiException
     */
    public function testGetUsers(): void
    {
        $users = $this->apiClient->getUsers();
        $this->assertFalse($users->hasPreviousPage());

        $firstUserOfPage = [];
        for ($i = 0; $i < 3; $i++) {
            $this->assertValidResultList($users);
            $firstUserOfPage[$i] = $users[0];

            foreach ($users as $user) {
                $this->assertNotNull($user);
                $this->assertNotNull($user->getName());
            }

            $this->assertTrue($users->hasNextPage());
            $users = $users->getNextPage();
        }

        for ($i = 2; $i >= 0; $i--) {
            $this->assertTrue($users->hasPreviousPage());
            $users = $users->getPreviousPage();

            $this->assertValidResultList($users);
            $this->assertEquals($firstUserOfPage[$i]->getName(), $users[0]->getName());

            foreach ($users as $user) {
                $this->assertNotNull($user);
                $this->assertNotNull($user->getName());
            }
            $this->assertTrue($users->hasNextPage());
        }
        $this->assertFalse($users->hasPreviousPage());
    }

    /**
     * Test case for getUser
     * @throws ApiException
     */
    public function testGetUser(): void
    {
        $user = $this->apiClient->getUser("Aternos");
        $this->assertNotNull($user);
        $this->assertEquals("Aternos", $user->getName());
    }

    /**
     * Test case for getProjectsWatchedByUser
     * @throws ApiException
     */
    public function testGetProjectsWatchedByUser(): void
    {
        $user = $this->apiClient->getUser("Julian");
        $this->assertNotNull($user);
        $this->assertEquals("Julian", $user->getName());

        $watched = $user->fetchWatchedProjects();
        $this->assertValidResultList($watched);

        foreach ($watched as $project) {
            $this->assertValidCompactProject($project);
        }
    }

    /**
     * Test case for getProjectsStarredByUser
     * @throws ApiException
     */
    public function testGetProjectsStarredByUser(): void
    {
        $user = $this->apiClient->getUser("Julian");
        $this->assertNotNull($user);
        $this->assertEquals("Julian", $user->getName());

        $starred = $user->fetchStarredProjects();
        $this->assertValidResultList($starred);

        foreach ($starred as $project) {
            $this->assertValidCompactProject($project);
        }
    }

    /**
     * Test that the sort field and order are kept when loading the next page of starred projects
     * @throws ApiException
     */
    public function testGetProjectsStarredByUserSortedByStarsKeepsSortOnNextPage(): void
    {
        $starred = $this->apiClient->getProjectsStarredByUser("kennytv", ProjectSortField::STARS, ProjectSortOrder::DESC, 3);
        $stars = [];
        for ($i = 0; $i < 2; $i++) {
            $this->assertValidResultList($starred);
            foreach ($starred as $project) {
                $this->assertValidCompactProject($project);
                $stars[] = $project->getStats()->getStars();
            }
            $starred = $starred->getNextPage();
        }

        $sorted = $stars;
        rsort($sorted);
        $this->assertSame($sorted, $stars);
    }

    /**
     * Test that the API accepts a sort field in a sort order for starred projects
     * @throws ApiException
     */
    #[DataProvider('projectSortProvider')]
    public function testProjectsStarredByUserSortIsSupported(ProjectSortField $sortField, ProjectSortOrder $sortOrder): void
    {
        if ($sortField === ProjectSortField::UPDATED) {
            $this->markTestSkipped("The Hangar API currently responds with HTTP 500 when sorting by 'updated' on this endpoint");
        }

        $starred = $this->apiClient->getProjectsStarredByUser("kennytv", $sortField, $sortOrder, 1);
        $this->assertValidResultList($starred);
    }

    /**
     * Test that the API accepts a sort field in a sort order for watched projects
     * @throws ApiException
     */
    #[DataProvider('projectSortProvider')]
    public function testProjectsWatchedByUserSortIsSupported(ProjectSortField $sortField, ProjectSortOrder $sortOrder): void
    {
        if ($sortField === ProjectSortField::UPDATED) {
            $this->markTestSkipped("The Hangar API currently responds with HTTP 500 when sorting by 'updated' on this endpoint");
        }

        $watched = $this->apiClient->getProjectsWatchedByUser("kennytv", $sortField, $sortOrder, 1);
        $this->assertValidResultList($watched);
    }

    /**
     * Test case for getting the projects of a user
     * @throws ApiException
     */
    public function testGetProjectsOfUser(): void
    {
        $user = $this->apiClient->getUser("Aternos");
        $this->assertNotNull($user);
        $this->assertEquals("Aternos", $user->getName());

        $projects = $user->fetchProjects();
        $this->assertValidResultList($projects);

        foreach ($projects as $project) {
            $this->assertValidProject($project);
            $this->assertEquals("Aternos", $project->getNamespace()->getOwner());
        }

        $this->assertGreaterThanOrEqual(2, $projects->getPagination()->getCount());
    }

    /**
     * Test case for getStaff
     * @throws ApiException
     */
    public function testGetStaff(): void
    {
        $users = $this->apiClient->getStaff(limit: 1);
        $this->assertFalse($users->hasPreviousPage());

        $firstUserOfPage = [];
        for ($i = 0; $i < 3; $i++) {
            $this->assertValidResultList($users);
            $firstUserOfPage[$i] = $users[0];

            foreach ($users as $user) {
                $this->assertNotNull($user);
                $this->assertNotNull($user->getName());
            }

            $this->assertTrue($users->hasNextPage());
            $users = $users->getNextPage();
        }

        for ($i = 2; $i >= 0; $i--) {
            $this->assertTrue($users->hasPreviousPage());
            $users = $users->getPreviousPage();

            $this->assertValidResultList($users);
            $this->assertEquals($firstUserOfPage[$i]->getName(), $users[0]->getName());

            foreach ($users as $user) {
                $this->assertNotNull($user);
                $this->assertNotNull($user->getName());
            }
            $this->assertTrue($users->hasNextPage());
        }
        $this->assertFalse($users->hasPreviousPage());
    }

    /**
     * Test case for getAuthors
     * @throws ApiException
     */
    public function testGetAuthors(): void
    {
        $users = $this->apiClient->getAuthors(limit: 10);
        $this->assertFalse($users->hasPreviousPage());

        $firstUserOfPage = [];
        for ($i = 0; $i < 3; $i++) {
            $this->assertValidResultList($users);
            $firstUserOfPage[$i] = $users[0];

            foreach ($users as $user) {
                $this->assertNotNull($user);
                $this->assertNotNull($user->getName());
            }

            $this->assertTrue($users->hasNextPage());
            $users = $users->getNextPage();
        }

        for ($i = 2; $i >= 0; $i--) {
            $this->assertTrue($users->hasPreviousPage());
            $users = $users->getPreviousPage();

            $this->assertValidResultList($users);
            $this->assertEquals($firstUserOfPage[$i]->getName(), $users[0]->getName());

            foreach ($users as $user) {
                $this->assertNotNull($user);
                $this->assertNotNull($user->getName());
            }
            $this->assertTrue($users->hasNextPage());
        }
        $this->assertFalse($users->hasPreviousPage());
    }

    /**
     * All staff sort fields
     * @return array<string, array{StaffSortField}>
     */
    public static function staffSortProvider(): array
    {
        $data = [];
        foreach (StaffSortField::cases() as $sortField) {
            $data[$sortField->name] = [$sortField];
        }
        return $data;
    }

    /**
     * Test that the API accepts a staff sort field
     * @throws ApiException
     */
    #[DataProvider('staffSortProvider')]
    public function testStaffSortIsSupported(StaffSortField $sortField): void
    {
        $users = $this->apiClient->getStaff(sort: $sortField, limit: 1);
        $this->assertValidResultList($users);
    }

    /**
     * All author sort fields
     * @return array<string, array{AuthorSortField}>
     */
    public static function authorSortProvider(): array
    {
        $data = [];
        foreach (AuthorSortField::cases() as $sortField) {
            $data[$sortField->name] = [$sortField];
        }
        return $data;
    }

    /**
     * Test that the API accepts an author sort field
     * @throws ApiException
     */
    #[DataProvider('authorSortProvider')]
    public function testAuthorSortIsSupported(AuthorSortField $sortField): void
    {
        $users = $this->apiClient->getAuthors(sort: $sortField, limit: 1);
        $this->assertValidResultList($users);
    }

    /**
     * Test that the sort field is kept when loading the next page of authors
     * @throws ApiException
     */
    public function testGetAuthorsSortedByNameKeepsSortOnNextPage(): void
    {
        $users = $this->apiClient->getAuthors(sort: AuthorSortField::NAME, limit: 5);
        $names = [];
        for ($i = 0; $i < 2; $i++) {
            $this->assertValidResultList($users);
            foreach ($users as $user) {
                $names[] = $user->getName();
            }
            $users = $users->getNextPage();
        }

        $sorted = $names;
        usort($sorted, strcasecmp(...));
        $this->assertSame($sorted, $names);
    }

    /**
     * Test case for getProjectPage and getProjectMainPage
     * @throws ApiException
     */
    public function testGetProjectPage(): void
    {
        $page = $this->apiClient->getProjectMainPage("mclogs");
        $this->assertNotNull($page);
        $this->assertNotNull($page->getContent());
        $this->assertNotEmpty($page->getContent());
        $this->assertNotNull($page->getPath());
        $project = $page->fetchProject();
        $this->assertEquals($page->getContent(), $project->fetchMainPage()->getContent());

        $configPage = $project->fetchPage("Config");
        $this->assertNotNull($configPage);
        $this->assertNotNull($configPage->getContent());
        $this->assertNotEmpty($configPage->getContent());
        $this->assertNotNull($configPage->getPath());
        $this->assertEquals($configPage->getContent(), $project->fetchPage("Config")->getContent());
        $this->assertEquals($configPage->getContent(), $project->fetchPage("/Config")->getContent());
        $this->assertEquals($configPage->getContent(), $project->fetchPage("/Config/")->getContent());
    }
}
