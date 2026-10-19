<?php

namespace Aternos\HangarApi\Tests\Unit\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\CompactProject;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSearchOptions;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSortField;
use Aternos\HangarApi\Client\Options\ProjectSearch\ProjectSortOrder;
use Aternos\HangarApi\Client\Options\UserSearch\AuthorSortField;
use Aternos\HangarApi\Client\Options\UserSearch\StaffSortField;
use Aternos\HangarApi\Client\Options\UserSearch\UserSearchOptions;
use Aternos\HangarApi\Client\Options\UserSearch\UserSortField;
use Aternos\HangarApi\Client\Options\VersionSearch\VersionSearchOptions;
use Aternos\HangarApi\Client\Project;
use Aternos\HangarApi\Client\User;
use Aternos\HangarApi\Client\Version;
use Aternos\HangarApi\Model\Category;
use Aternos\HangarApi\Model\Platform;
use Aternos\HangarApi\Model\ProjectMember;
use Aternos\HangarApi\Model\Tag;
use Composer\InstalledVersions;
use GuzzleHttp\Psr7\Response;

class HangarAPIClientTest extends ClientTestCase
{
    public function testGetLibraryVersionReturnsInstalledVersion(): void
    {
        $this->assertEquals(
            InstalledVersions::getPrettyVersion(HangarAPIClient::PACKAGE_NAME),
            HangarAPIClient::getLibraryVersion()
        );
        $this->assertNotEquals("unknown", HangarAPIClient::getLibraryVersion());
    }

    public function testDefaultUserAgentContainsPackageAndVersion(): void
    {
        $this->assertEquals(
            "aternos/php-hangar-api/" . HangarAPIClient::getLibraryVersion(),
            HangarAPIClient::getDefaultUserAgent()
        );
    }

    /**
     * @throws ApiException
     */
    public function testDefaultUserAgentIsSentWithRequests(): void
    {
        $client = $this->createClient([new Response(200, [], "1.0.0")]);

        $client->getLatestReleaseVersion("mclogs");

        $this->assertEquals(HangarAPIClient::getDefaultUserAgent(), $this->getRequest()->getHeaderLine("User-Agent"));
    }

    /**
     * @throws ApiException
     */
    public function testUserAgentFromConstructorReplacesDefaultUserAgent(): void
    {
        $client = $this->createClient([new Response(200, [], "1.0.0")], "test-agent/1.0");

        $client->getLatestReleaseVersion("mclogs");

        $this->assertEquals("test-agent/1.0", $this->getRequest()->getHeaderLine("User-Agent"));
    }

    /**
     * @throws ApiException
     */
    public function testSetUserAgentReplacesDefaultUserAgent(): void
    {
        $client = $this->createClient([new Response(200, [], "1.0.0")]);

        $this->assertSame($client, $client->setUserAgent("test-agent/1.0"));
        $client->getLatestReleaseVersion("mclogs");

        $this->assertEquals("test-agent/1.0", $this->getRequest()->getHeaderLine("User-Agent"));
    }

    /**
     * @throws ApiException
     */
    public function testGetProjects(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjects.json"))]);

        $projects = $client->getProjects();

        $this->assertGetRequest("/projects", ["prioritizeExactMatch" => "1", "limit" => "25", "offset" => "0"]);
        foreach (["sort", "category", "platform", "owner", "query", "license", "version", "tag"] as $parameter) {
            $this->assertArrayNotHasKey($parameter, $this->getQuery());
        }
        $this->assertCount(2, $projects);
        $this->assertContainsOnlyInstancesOf(Project::class, $projects->getResults());
        $this->assertSame("WirelessRedstoneTrigger", $projects[0]->getSlug());
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectsWithOptions(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjects.json"))]);
        $options = new ProjectSearchOptions()
            ->setPrioritizeExactMatch(false)
            ->setSortField(ProjectSortField::STARS)
            ->setSortOrder(ProjectSortOrder::DESC)
            ->setCategory(Category::CHAT)
            ->setPlatform(Platform::PAPER)
            ->setOwner("Aternos")
            ->setQuery("maintenance mode")
            ->setLicense("MIT")
            ->setVersion("1.21")
            ->setTag(Tag::ADDON)
            ->setLimit(2)
            ->setOffset(4);

        $client->getProjects($options);

        $this->assertGetRequest("/projects", [
            "prioritizeExactMatch" => "0",
            "sort" => "-stars",
            "category" => "chat",
            "platform" => "PAPER",
            "owner" => "Aternos",
            "query" => "maintenance mode",
            "license" => "MIT",
            "version" => "1.21",
            "tag" => "ADDON",
            "limit" => "2",
            "offset" => "4",
        ]);
    }

    /**
     * @throws ApiException
     */
    public function testGetProject(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json"))]);

        $project = $client->getProject("mclogs");

        $this->assertGetRequest("/projects/mclogs");
        $this->assertSame(246, $project->getId());
        $this->assertSame("mclogs", $project->getSlug());
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectByVersionHash(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json"))]);
        $hash = str_repeat("ab", 32);

        $project = $client->getProjectByVersionHash($hash);

        $this->assertGetRequest("/versions/hash/" . $hash);
        $this->assertSame("mclogs", $project->getSlug());
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectWatchers(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjectWatchers.json"))]);

        $watchers = $client->getProjectWatchers("mclogs", 2, 4);

        $this->assertGetRequest("/projects/mclogs/watchers", ["limit" => "2", "offset" => "4"]);
        $this->assertCount(2, $watchers);
        $this->assertContainsOnlyInstancesOf(User::class, $watchers->getResults());
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectStarGazers(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjectStargazers.json"))]);

        $stargazers = $client->getProjectStarGazers("mclogs", 2, 4);

        $this->assertGetRequest("/projects/mclogs/stargazers", ["limit" => "2", "offset" => "4"]);
        $this->assertCount(2, $stargazers);
        $this->assertContainsOnlyInstancesOf(User::class, $stargazers->getResults());
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectMembers(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProjectMembers.json"))]);

        $members = $client->getProjectMembers("mclogs", 2, 4);

        $this->assertGetRequest("/projects/mclogs/members", ["limit" => "2", "offset" => "4"]);
        $this->assertCount(1, $members);
        $this->assertInstanceOf(ProjectMember::class, $members[0]);
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectVersions(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/listVersions.json"))]);

        $versions = $client->getProjectVersions("mclogs", new VersionSearchOptions("mclogs"));

        $this->assertGetRequest("/projects/mclogs/versions", [
            "includeHiddenChannels" => "1",
            "limit" => "25",
            "offset" => "0",
        ]);
        $this->assertArrayNotHasKey("channel", $this->getQuery());
        $this->assertArrayNotHasKey("platform", $this->getQuery());
        $this->assertCount(2, $versions);
        $this->assertContainsOnlyInstancesOf(Version::class, $versions->getResults());
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectVersionsWithOptions(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/listVersions.json"))]);
        $options = new VersionSearchOptions("mclogs")
            ->setChannel("Release")
            ->setPlatform(Platform::PAPER)
            ->setIncludeHiddenChannels(false)
            ->setLimit(2)
            ->setOffset(4);

        $client->getProjectVersions("mclogs", $options);

        $this->assertGetRequest("/projects/mclogs/versions", [
            "includeHiddenChannels" => "0",
            "channel" => "Release",
            "platform" => "PAPER",
            "limit" => "2",
            "offset" => "4",
        ]);
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectVersionsOfProjectUsesProjectId(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/listVersions.json"))
        ]);
        $project = $client->getProject("mclogs");

        $client->getProjectVersions($project, new VersionSearchOptions("mclogs"));

        $this->assertGetRequest("/projects/246/versions", index: 1);
        $this->assertRequestCount(2);
    }

    /**
     * @throws ApiException
     */
    public function testGetLatestReleaseVersion(): void
    {
        $client = $this->createClient([new Response(200, ["Content-Type" => "text/plain"], "3.3.4")]);

        $this->assertSame("3.3.4", $client->getLatestReleaseVersion("mclogs"));
        $this->assertGetRequest("/projects/mclogs/latestrelease");
    }

    /**
     * @throws ApiException
     */
    public function testGetLatestVersion(): void
    {
        $client = $this->createClient([new Response(200, ["Content-Type" => "text/plain"], "5.2.0-SNAPSHOT")]);

        $this->assertSame("5.2.0-SNAPSHOT", $client->getLatestVersion("mclogs", "Snapshot"));
        $this->assertGetRequest("/projects/mclogs/latest", ["channel" => "Snapshot"]);
    }

    /**
     * @throws ApiException
     */
    public function testGetVersion(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showVersion.json"))]);

        $version = $client->getVersion("mclogs", "3.3.4");

        $this->assertGetRequest("/projects/mclogs/versions/3.3.4");
        $this->assertSame(30673, $version->getData()->getId());
        $this->assertSame("mclogs", $version->getProjectSlugOrId());
    }

    /**
     * @throws ApiException
     */
    public function testGetVersionOfProjectUsesProjectId(): void
    {
        $client = $this->createClient([
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getProject.json")),
            new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showVersion.json"))
        ]);
        $project = $client->getProject("mclogs");

        $version = $client->getVersion($project, "3.3.4");

        $this->assertGetRequest("/projects/246/versions/3.3.4", index: 1);
        $this->assertSame($project, $version->getProject());
        $this->assertRequestCount(2);
    }

    /**
     * @throws ApiException
     */
    public function testGetVersionById(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showVersion.json"))]);

        $version = $client->getVersionById(30673);

        $this->assertGetRequest("/versions/30673");
        $this->assertSame("3.3.4", $version->getData()->getName());
    }

    /**
     * @throws ApiException
     */
    public function testGetUsers(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showUsers.json"))]);

        $users = $client->getUsers();

        $this->assertGetRequest("/users", ["query" => "", "limit" => "25", "offset" => "0"]);
        $this->assertArrayNotHasKey("sort", $this->getQuery());
        $this->assertCount(1, $users);
        $this->assertContainsOnlyInstancesOf(User::class, $users->getResults());
    }

    /**
     * @throws ApiException
     */
    public function testGetUsersWithOptions(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showUsers.json"))]);
        $options = new UserSearchOptions()
            ->setQuery("kenny")
            ->setSort(UserSortField::PROJECT_COUNT)
            ->setLimit(2)
            ->setOffset(4);

        $client->getUsers($options);

        $this->assertGetRequest("/users", ["query" => "kenny", "sort" => "projectCount", "limit" => "2", "offset" => "4"]);
    }

    /**
     * @throws ApiException
     */
    public function testGetUser(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUser.json"))]);

        $user = $client->getUser("Aternos");

        $this->assertGetRequest("/users/Aternos");
        $this->assertSame(196, $user->getData()->getId());
        $this->assertSame("Aternos", $user->getData()->getName());
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectsWatchedByUser(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUserWatching.json"))]);

        $projects = $client->getProjectsWatchedByUser("Aternos", ProjectSortField::DOWNLOADS, ProjectSortOrder::DESC, 2, 4);

        $this->assertGetRequest("/users/Aternos/watching", ["sort" => "-downloads", "limit" => "2", "offset" => "4"]);
        $this->assertCount(2, $projects);
        $this->assertContainsOnlyInstancesOf(CompactProject::class, $projects->getResults());
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectsStarredByUser(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/showStarred.json"))]);

        $projects = $client->getProjectsStarredByUser("Aternos", ProjectSortField::STARS, ProjectSortOrder::ASC, 2, 4);

        $this->assertGetRequest("/users/Aternos/starred", ["sort" => "stars", "limit" => "2", "offset" => "4"]);
        $this->assertCount(2, $projects);
        $this->assertContainsOnlyInstancesOf(CompactProject::class, $projects->getResults());
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectsPinnedByUser(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getUserPinnedProjects.json"))]);

        $projects = $client->getProjectsPinnedByUser("Aternos");

        $this->assertGetRequest("/users/Aternos/pinned");
        $this->assertCount(2, $projects);
        $this->assertContainsOnlyInstancesOf(CompactProject::class, $projects);
    }

    /**
     * @throws ApiException
     */
    public function testGetStaff(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getStaff.json"))]);

        $staff = $client->getStaff("mini", StaffSortField::ROLES, 2, 4);

        $this->assertGetRequest("/staff", ["query" => "mini", "sort" => "roles", "limit" => "2", "offset" => "4"]);
        $this->assertCount(2, $staff);
        $this->assertContainsOnlyInstancesOf(User::class, $staff->getResults());
    }

    /**
     * @throws ApiException
     */
    public function testGetAuthors(): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/getAuthors.json"))]);

        $authors = $client->getAuthors("kenny", AuthorSortField::CREATED_AT, 2, 4);

        $this->assertGetRequest("/authors", ["query" => "kenny", "sort" => "createdAt", "limit" => "2", "offset" => "4"]);
        $this->assertCount(2, $authors);
        $this->assertContainsOnlyInstancesOf(User::class, $authors->getResults());
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectMainPage(): void
    {
        $client = $this->createClient([new Response(200, ["Content-Type" => "text/plain"], "# mclogs")]);

        $page = $client->getProjectMainPage("mclogs");

        $this->assertGetRequest("/pages/main/mclogs");
        $this->assertSame("# mclogs", $page->getContent());
    }

    /**
     * @throws ApiException
     */
    public function testGetProjectPage(): void
    {
        $client = $this->createClient([new Response(200, ["Content-Type" => "text/plain"], "# Config")]);

        $page = $client->getProjectPage("mclogs", "config");

        $this->assertGetRequest("/pages/page/mclogs", ["path" => "config"]);
        $this->assertSame("# Config", $page->getContent());
        $this->assertSame("config", $page->getPath());
    }
}
