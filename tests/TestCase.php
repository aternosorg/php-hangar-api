<?php

namespace Aternos\HangarApi\Tests;

use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Model\Project;
use Aternos\HangarApi\Model\ProjectSettings;
use Aternos\HangarApi\Model\ProjectStats;
use Aternos\HangarApi\Model\User;
use Aternos\HangarApi\Model\Version;
use Aternos\HangarApi\Model\VersionStats;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{

    protected ?HangarAPIClient $apiClient = null;

    /**
     * Setup before running each test case
     */
    public function setUp(): void
    {
        $this->apiClient = new HangarAPIClient();
        $this->apiClient->setUserAgent("aternos/php-hangar-api@5.2.0 (contact@aternos.org)");
    }

    protected function assertValidUser(User $user): void
    {
        $this->assertNotNull($user->getId());
        $this->assertNotNull($user->getAvatarUrl());
        $this->assertNotNull($user->getCreatedAt());
        $this->assertIsBool($user->getIsOrganization());
        $this->assertIsBool($user->getLocked());
        $this->assertNotNull($user->getName());
        // $user->getNameHistory() can be null or array
        $this->assertIsNumeric($user->getProjectCount());
        $this->assertIsArray($user->getRoles());
        $this->assertNotNull($user->getSocials());
        // $user->getTagline() can be null
    }

    protected function assertValidProjectSettings(ProjectSettings $projectSettings): void
    {
        $this->assertNotNull($projectSettings->getDonation());
        $this->assertIsArray($projectSettings->getKeywords());
        $this->assertNotNull($projectSettings->getLicense());
        $this->assertIsArray($projectSettings->getLinks());
        // $projectSettings->getSponsors() can be null
        $this->assertIsArray($projectSettings->getTags());
    }

    protected function assertValidProjectStats(ProjectStats $projectStats): void
    {
        $this->assertIsNumeric($projectStats->getDownloads());
        $this->assertIsNumeric($projectStats->getRecentDownloads());
        $this->assertIsNumeric($projectStats->getRecentViews());
        $this->assertIsNumeric($projectStats->getStars());
        $this->assertIsNumeric($projectStats->getViews());
        $this->assertIsNumeric($projectStats->getWatchers());
    }

    protected function assertValidProject(Project $project): void
    {
        $this->assertNotNull($project->getAvatarUrl());
        $this->assertNotNull($project->getCategory());
        $this->assertNotNull($project->getCreatedAt());
        $this->assertNotNull($project->getDescription());
        $this->assertIsNumeric($project->getId());
        $this->assertNotNull($project->getLastUpdated());
        // $project->getMainPageContent() can be null
        // $project->getMemberNames() can be null or array
        $this->assertNotNull($project->getName());
        $this->assertNotNull($project->getNamespace());
        $this->assertValidProjectSettings($project->getSettings());
        $this->assertValidProjectStats($project->getStats());
        $this->assertIsArray($project->getSupportedPlatforms());
        // $project->getUserActions() is null if not authenticated
        $this->assertNotNull($project->getVisibility());
    }

    protected function assertValidVersionStats(VersionStats $versionStats): void
    {
        $this->assertIsNumeric($versionStats->getTotalDownloads());

        $platformDownloads = $versionStats->getPlatformDownloads();
        $this->assertIsArray($platformDownloads);

        $total = 0;
        foreach ($platformDownloads as $platform => $downloads) {
            $this->assertIsString($platform);
            $this->assertIsNumeric($downloads);
            $total += $downloads;
        }

        $this->assertEquals($versionStats->getTotalDownloads(), $total);
    }

    protected function assertValidVersion(Version $version): void
    {
        $this->assertNotNull($version->getAuthor());
        $this->assertNotNull($version->getChannel());
        $this->assertNotNull($version->getCreatedAt());
        $this->assertNotNull($version->getDescription());
        $this->assertIsArray($version->getDownloads());
        $this->assertIsNumeric($version->getId());
        // $version->getMemberNames() can be null or array
        $this->assertNotNull($version->getName());
        $this->assertNotNull($version->getPinnedStatus());
        $this->assertIsArray($version->getPlatformDependencies());
        $this->assertIsArray($version->getPlatformDependenciesFormatted());
        $this->assertIsArray($version->getPluginDependencies());
        $this->assertIsNumeric($version->getProjectId());
        $this->assertNotNull($version->getReviewState());
        $this->assertValidVersionStats($version->getStats());
        $this->assertNotNull($version->getVisibility());
    }
}
