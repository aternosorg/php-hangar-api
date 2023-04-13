<?php

namespace Aternos\HangarApi\Test\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\Options\ProjectCategory;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
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
            $this->assertNotNull($projectList);
            $this->assertNotNull($projectList->getResults());
            $this->assertNotEmpty($projectList->getResults());
            $firstProjectOfPages[$i] = $projectList->getResults()[0];

            foreach ($projectList->getResults() as $project) {
                $this->assertValidProject($project);
            }

            $this->assertTrue($projectList->hasNextPage());
            $projectList = $projectList->getNextPage();
        }

        for ($i = 2; $i >= 0; $i--) {
            $this->assertTrue($projectList->hasPreviousPage());
            $projectList = $projectList->getPreviousPage();

            $this->assertNotNull($projectList);
            $this->assertNotNull($projectList->getResults());
            $this->assertNotEmpty($projectList->getResults());
            $this->assertTrue($this->isSameProject($firstProjectOfPages[$i], $projectList->getResults()[0]));
            $firstProjectOfPages[$i] = $projectList->getResults()[0];

            foreach ($projectList->getResults() as $project) {
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
            $this->assertNotNull($projectList);
            $this->assertNotNull($projectList->getResults());
            $this->assertNotEmpty($projectList->getResults());
            $firstProjectOfPages[$i] = $projectList->getResults()[0];

            foreach ($projectList->getResults() as $project) {
                $this->assertValidProject($project);
                $this->assertEquals(ProjectCategory::ADMIN_TOOLS->value, $project->getData()->getCategory());
            }

            $this->assertTrue($projectList->hasNextPage());
            $projectList = $projectList->getNextPage();
        }

        for ($i = 2; $i >= 0; $i--) {
            $this->assertTrue($projectList->hasPreviousPage());
            $projectList = $projectList->getPreviousPage();

            $this->assertNotNull($projectList);
            $this->assertNotNull($projectList->getResults());
            $this->assertNotEmpty($projectList->getResults());
            $this->assertTrue($this->isSameProject($firstProjectOfPages[$i], $projectList->getResults()[0]));
            $firstProjectOfPages[$i] = $projectList->getResults()[0];

            foreach ($projectList->getResults() as $project) {
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
        $this->assertNotNull($projectList);
        $this->assertFalse($projectList->hasPreviousPage());
        $this->assertNotNull($projectList->getResults());
        $this->assertNotEmpty($projectList->getResults());

        foreach ($projectList->getResults() as $project) {
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
        foreach ($versions->getResults() as $version) {
            $this->assertEquals($project, $version->getProject());
            $fetched = $project->getVersion($version->getData()->getName());
            $this->assertEquals($version->getData()->getName(), $fetched->getData()->getName());
        }
    }

    /**
     * Test case for fetching members of a project
     * This endpoint is currently broken due to a bug in the paper API docs: https://github.com/HangarMC/Hangar/issues/1138
     * @throws ApiException
     */
    public function testGetProjectMembers()
    {
        $project = $this->apiClient->getProject("Aternos", "motdgg");
        $this->assertNotNull($project);
        $this->assertValidProject($project);
        $this->assertEquals("Aternos", $project->getData()->getNamespace()->getOwner());

        $members = $project->getMembers();
        $this->assertNotNull($members);
        $this->assertNotEmpty($members->getResults());
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
        $this->assertNotNull($watchers);
        $this->assertNotEmpty($watchers->getResults());
        $this->assertNotEmpty(array_filter($watchers->getResults(), function ($watcher) {
            return $watcher->getData()->getName() == "JulianVennen";
        }));

        foreach ($watchers->getResults() as $watcher) {
            $projects = $watcher->getWatchedProjects();
            $this->assertNotNull($projects);
            $this->assertNotEmpty($projects->getResults());
            $this->assertNotEmpty(array_filter($projects->getResults(), function ($watchedProject) use ($project) {
                return $this->isSameProject($watchedProject, $project);
            }));
        }
    }

    /**
     * Test case for fetching project day stats
     * @throws ApiException
     */
    public function testGetProjectDayStats()
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
}
