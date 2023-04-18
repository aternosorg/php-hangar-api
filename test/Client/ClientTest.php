<?php

namespace Aternos\HangarApi\Test\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\List\ResultList;
use Aternos\HangarApi\Client\Options\ProjectCategory;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
use Aternos\HangarApi\Model\RequestPagination;
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
        $this->apiClient->setUserAgent("aternos/php-hangar-api@1.0.0 (contact@aternos.org)");
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
        $this->assertInstanceOf(\Aternos\HangarApi\Model\ProjectNamespace::class, $namespace);
        $this->assertNotNull($namespace->getOwner());
        $this->assertNotNull($namespace->getSlug());
    }

    protected function assertValidProject($project): void
    {
        $this->assertNotNull($project);
        $this->assertNotNull($project->getData());
        $this->assertValidNamespace($project->getData()->getNamespace());
        $this->assertNotNull($project->getData()->getName());
        $this->assertNotNull($project->getData()->getStats());
        $this->assertNotNull($project->getData()->getStats()->getViews());
        $this->assertNotNull($project->getData()->getStats()->getDownloads());
        $this->assertNotNull($project->getData()->getStats()->getRecentViews());
        $this->assertNotNull($project->getData()->getStats()->getRecentDownloads());
        $this->assertNotNull($project->getData()->getStats()->getStars());
        $this->assertNotNull($project->getData()->getStats()->getWatchers());
        $this->assertNotNull($project->getData()->getCategory());
        $this->assertNotNull(ProjectCategory::from($project->getData()->getCategory()));
        $this->assertNotNull($project->getData()->getLastUpdated());
        $this->assertNotNull($project->getData()->getVisibility());
        $this->assertNotNull($project->getData()->getDescription());
        $this->assertNotNull($project->getData()->getUserActions());
        $this->assertNotNull($project->getData()->getSettings());
    }

    protected function assertValidCompactProject($project): void
    {
        $this->assertNotNull($project);
        $this->assertNotNull($project->getData());
        $this->assertValidNamespace($project->getData()->getNamespace());
        $this->assertNotNull($project->getData()->getName());
        $this->assertNotNull($project->getData()->getStats());
        $this->assertNotNull($project->getData()->getStats()->getViews());
        $this->assertNotNull($project->getData()->getStats()->getDownloads());
        $this->assertNotNull($project->getData()->getStats()->getRecentViews());
        $this->assertNotNull($project->getData()->getStats()->getRecentDownloads());
        $this->assertNotNull($project->getData()->getStats()->getStars());
        $this->assertNotNull($project->getData()->getStats()->getWatchers());
        $this->assertNotNull($project->getData()->getCategory());
        $this->assertNotNull(ProjectCategory::from($project->getData()->getCategory()));
        $this->assertNotNull($project->getData()->getLastUpdated());
        $this->assertNotNull($project->getData()->getVisibility());
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
        if (!$a || !$b) {
            return false;
        }

        if (!$a->getData() || !$b->getData()) {
            return false;
        }

        if (!$a->getData()->getNamespace() || !$b->getData()->getNamespace()) {
            return false;
        }

        if (!$a->getData()->getNamespace()->getOwner() || !$b->getData()->getNamespace()->getOwner()) {
            return false;
        }

        if (!$a->getData()->getNamespace()->getSlug() || !$b->getData()->getNamespace()->getSlug()) {
            return false;
        }

        if ($a->getData()->getNamespace()->getOwner() !== $b->getData()->getNamespace()->getOwner()) {
            return false;
        }

        if ($a->getData()->getNamespace()->getSlug() !== $b->getData()->getNamespace()->getSlug()) {
            return false;
        }

        return true;
    }


    /**
     * Test case for getProjects
     * @throws ApiException
     */
    public function testGetProjects()
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
    public function testGetProjectsInCategory()
    {
        $options = new ProjectSearchOptions();
        $options->setCategory(ProjectCategory::ADMIN_TOOLS);
        $options->setLimit(10);
        $projectList = $this->apiClient->getProjects($options);
        $this->assertFalse($projectList->hasPreviousPage());

        $firstProjectOfPages = [];
        for ($i = 0; $i < 3; $i++) {
            $this->assertValidResultList($projectList);
            $firstProjectOfPages[$i] = $projectList[0];

            foreach ($projectList as $project) {
                $this->assertValidProject($project);
                $this->assertEquals(ProjectCategory::ADMIN_TOOLS->value, $project->getData()->getCategory());
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
                $this->assertEquals(ProjectCategory::ADMIN_TOOLS->value, $project->getData()->getCategory());
            }
            $this->assertTrue($projectList->hasNextPage());
        }
        $this->assertFalse($projectList->hasPreviousPage());
    }

    /**
     * Test case for getProjects with a specified owner
     * @throws ApiException
     */
    public function testGetProjectsByOwner()
    {
        $options = new ProjectSearchOptions();
        $options->setOwner("Aternos");
        $options->setLimit(10);
        $projectList = $this->apiClient->getProjects($options);
        $this->assertValidResultList($projectList);

        foreach ($projectList as $project) {
            $this->assertValidProject($project);
            $this->assertEquals("Aternos", $project->getData()->getNamespace()->getOwner());
        }

        $this->assertEquals(2, $projectList->getPagination()->getCount());
        $this->assertFalse($projectList->hasNextPage());
        $projectList = $projectList->getNextPage();
        $this->assertNull($projectList);
    }

    /**
     * Test case for getProject
     * @throws ApiException
     */
    public function testGetProject()
    {
        $project = $this->apiClient->getProject("Aternos", "mclogs");
        $this->assertNotNull($project);
        $this->assertValidProject($project);
        $this->assertEquals("Aternos", $project->getData()->getNamespace()->getOwner());

        $versions = $project->getVersions();
        $this->assertNotNull($versions);
        $this->assertNotEmpty($versions);
        foreach ($versions as $version) {
            $this->assertEquals($project, $version->getProject());
            $fetched = $project->getVersion($version->getData()->getName());
            $this->assertEquals($version->getData()->getName(), $fetched->getData()->getName());
        }
    }

    /**
     * Test case for fetching members of a project
     * @throws ApiException
     */
    public function testGetProjectMembers()
    {
        $project = $this->apiClient->getProject("Aternos", "motdgg");
        $this->assertNotNull($project);
        $this->assertValidProject($project);
        $this->assertEquals("Aternos", $project->getData()->getNamespace()->getOwner());

        $members = $project->getMembers();
        $this->assertValidResultList($members);
        $this->assertNotEmpty(array_filter($members->getResults(), function ($member) {
            return $member->getUser() == "Aternos";
        }));
    }

    /**
     * Test case for fetching users watching a project
     * @throws ApiException
     */
    public function testGetProjectWatchers()
    {
        $project = $this->apiClient->getProject("Aternos", "motdgg");
        $this->assertNotNull($project);
        $this->assertValidProject($project);
        $this->assertEquals("Aternos", $project->getData()->getNamespace()->getOwner());

        $watchers = $project->getWatchers();
        $this->assertValidResultList($watchers);
        $this->assertNotEmpty(array_filter($watchers->getResults(), function ($watcher) {
            return $watcher->getData()->getName() == "Julian";
        }));

        foreach ($watchers as $watcher) {
            $projects = $watcher->getWatchedProjects();
            $this->assertValidResultList($projects);
            $this->assertNotEmpty(array_filter($projects->getResults(), function ($watchedProject) use ($project) {
                return $this->isSameProject($watchedProject, $project);
            }));
        }
    }

    /**
     * Test case for fetching project day stats
     * @throws ApiException
     */
    public function testGetDailyProjectStats()
    {
        $project = $this->apiClient->getProject("Aternos", "mclogs");
        $this->assertNotNull($project);
        $this->assertValidProject($project);

        $stats = $project->getDailyStats();
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
    public function testGetDailyProjectVersionStats()
    {
        $project = $this->apiClient->getProject("Aternos", "mclogs");
        $this->assertNotNull($project);
        $this->assertValidProject($project);

        $versions = $project->getVersions();
        $this->assertValidResultList($versions);
        foreach ($versions as $version) {
            foreach ($version->getData()->getStats()->getPlatformDownloads() as $downloads) {
                if ($downloads > 0) {
                    $stats = $version->getDailyStats();
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
    public function testGetUsers()
    {
        $users = $this->apiClient->getUsers();
        $this->assertFalse($users->hasPreviousPage());

        $firstUserOfPage = [];
        for ($i = 0; $i < 3; $i++) {
            $this->assertValidResultList($users);
            $firstUserOfPage[$i] = $users[0];

            foreach ($users as $user) {
                $this->assertNotNull($user);
                $this->assertNotNull($user->getData());
                $this->assertNotNull($user->getData()->getName());
            }

            $this->assertTrue($users->hasNextPage());
            $users = $users->getNextPage();
        }

        for ($i = 2; $i >= 0; $i--) {
            $this->assertTrue($users->hasPreviousPage());
            $users = $users->getPreviousPage();

            $this->assertValidResultList($users);
            $this->assertEquals($firstUserOfPage[$i]->getData()->getName(), $users[0]->getData()->getName());

            foreach ($users as $user) {
                $this->assertNotNull($user);
                $this->assertNotNull($user->getData());
                $this->assertNotNull($user->getData()->getName());
            }
            $this->assertTrue($users->hasNextPage());
        }
        $this->assertFalse($users->hasPreviousPage());
    }

    /**
     * Test case for getUser
     * @throws ApiException
     */
    public function testGetUser()
    {
        $user = $this->apiClient->getUser("Aternos");
        $this->assertNotNull($user);
        $this->assertNotNull($user->getData());
        $this->assertEquals("Aternos", $user->getData()->getName());
    }

    /**
     * Test case for getProjectsWatchedByUser
     * @throws ApiException
     */
    public function testGetProjectsWatchedByUser()
    {
        $user = $this->apiClient->getUser("Julian");
        $this->assertNotNull($user);
        $this->assertNotNull($user->getData());
        $this->assertEquals("Julian", $user->getData()->getName());

        $watched =  $user->getWatchedProjects();
        $this->assertValidResultList($watched);

        foreach ($watched as $project) {
            $this->assertValidCompactProject($project);
        }
    }

    /**
     * Test case for getProjectsStarredByUser
     * @throws ApiException
     */
    public function testGetProjectsStarredByUser()
    {
        $user = $this->apiClient->getUser("Julian");
        $this->assertNotNull($user);
        $this->assertNotNull($user->getData());
        $this->assertEquals("Julian", $user->getData()->getName());

        $starred =  $user->getStarredProjects();
        $this->assertValidResultList($starred);

        foreach ($starred as $project) {
            $this->assertValidCompactProject($project);
        }
    }

    /**
     * Test case for getStaff
     * @throws ApiException
     */
    public function testGetStaff()
    {
        $pagination = (new RequestPagination())->setLimit(1);
        $users = $this->apiClient->getStaff($pagination);
        $this->assertFalse($users->hasPreviousPage());

        $firstUserOfPage = [];
        for ($i = 0; $i < 3; $i++) {
            $this->assertValidResultList($users);
            $firstUserOfPage[$i] = $users[0];

            foreach ($users as $user) {
                $this->assertNotNull($user);
                $this->assertNotNull($user->getData());
                $this->assertNotNull($user->getData()->getName());
            }

            $this->assertTrue($users->hasNextPage());
            $users = $users->getNextPage();
        }

        for ($i = 2; $i >= 0; $i--) {
            $this->assertTrue($users->hasPreviousPage());
            $users = $users->getPreviousPage();

            $this->assertValidResultList($users);
            $this->assertEquals($firstUserOfPage[$i]->getData()->getName(), $users[0]->getData()->getName());

            foreach ($users as $user) {
                $this->assertNotNull($user);
                $this->assertNotNull($user->getData());
                $this->assertNotNull($user->getData()->getName());
            }
            $this->assertTrue($users->hasNextPage());
        }
        $this->assertFalse($users->hasPreviousPage());
    }

    /**
     * Test case for getAuthors
     * @throws ApiException
     */
    public function testGetAuthors()
    {
        $pagination = (new RequestPagination())->setLimit(10);
        $users = $this->apiClient->getAuthors($pagination);
        $this->assertFalse($users->hasPreviousPage());

        $firstUserOfPage = [];
        for ($i = 0; $i < 3; $i++) {
            $this->assertValidResultList($users);
            $firstUserOfPage[$i] = $users[0];

            foreach ($users as $user) {
                $this->assertNotNull($user);
                $this->assertNotNull($user->getData());
                $this->assertNotNull($user->getData()->getName());
            }

            $this->assertTrue($users->hasNextPage());
            $users = $users->getNextPage();
        }

        for ($i = 2; $i >= 0; $i--) {
            $this->assertTrue($users->hasPreviousPage());
            $users = $users->getPreviousPage();

            $this->assertValidResultList($users);
            $this->assertEquals($firstUserOfPage[$i]->getData()->getName(), $users[0]->getData()->getName());

            foreach ($users as $user) {
                $this->assertNotNull($user);
                $this->assertNotNull($user->getData());
                $this->assertNotNull($user->getData()->getName());
            }
            $this->assertTrue($users->hasNextPage());
        }
        $this->assertFalse($users->hasPreviousPage());
    }

    /**
     * Test case for getProjectPage and getProjectMainPage
     * @throws ApiException
     */
    public function testGetProjectPage()
    {
        $page = $this->apiClient->getProjectMainPage("Aternos", "mclogs");
        $this->assertNotNull($page);
        $this->assertNotNull($page->getContent());
        $this->assertNotEmpty($page->getContent());
        $this->assertNotNull($page->getPath());
        $project = $page->getProject();
        $this->assertEquals($page->getContent(), $project->getMainPage()->getContent());

        $configPage = $project->getPage("Config");
        $this->assertNotNull($configPage);
        $this->assertNotNull($configPage->getContent());
        $this->assertNotEmpty($configPage->getContent());
        $this->assertNotNull($configPage->getPath());
        $this->assertEquals($configPage->getContent(), $project->getPage("Config")->getContent());
        $this->assertEquals($configPage->getContent(), $project->getPage("/Config")->getContent());
        $this->assertEquals($configPage->getContent(), $project->getPage("/Config/")->getContent());
    }
}
