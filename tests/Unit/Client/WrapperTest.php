<?php

namespace Aternos\HangarApi\Tests\Unit\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\CompactProject;
use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Client\Project;
use Aternos\HangarApi\Client\User;
use Aternos\HangarApi\Client\Version;
use Aternos\HangarApi\Model\Project as ProjectModel;
use Aternos\HangarApi\Model\ProjectCompact;
use Aternos\HangarApi\Model\User as UserModel;
use Aternos\HangarApi\Model\Version as VersionModel;
use Aternos\HangarApi\ObjectSerializer;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * Tests that apply to all wrappers that extend a generated model
 */
class WrapperTest extends ClientTestCase
{
    /**
     * Wrapper class, generated model class, fixture and a function that fetches the wrapper from the fixture
     * @return array<string, array{class-string, class-string, string, callable(HangarAPIClient): object}>
     */
    public static function wrapperProvider(): array
    {
        return [
            "Project" => [
                Project::class,
                ProjectModel::class,
                "getProject.json",
                fn(HangarAPIClient $client) => $client->getProject("mclogs"),
            ],
            "CompactProject" => [
                CompactProject::class,
                ProjectCompact::class,
                "getUserPinnedProjects.json",
                fn(HangarAPIClient $client) => $client->getProjectsPinnedByUser("Aternos")[0],
            ],
            "User" => [
                User::class,
                UserModel::class,
                "getUser.json",
                fn(HangarAPIClient $client) => $client->getUser("Aternos"),
            ],
            "Version" => [
                Version::class,
                VersionModel::class,
                "showVersion.json",
                fn(HangarAPIClient $client) => $client->getVersion("mclogs", "3.3.4"),
            ],
        ];
    }

    /**
     * Create the generated model from the first entry of a fixture, the way the generated API does
     * @param string $fixture
     * @param class-string $modelClass
     * @return object
     */
    protected function createModel(string $fixture, string $modelClass): object
    {
        $data = json_decode(file_get_contents(__DIR__ . "/Fixtures/" . $fixture));
        return ObjectSerializer::deserialize(is_array($data) ? $data[0] : $data, $modelClass);
    }

    /**
     * @throws ApiException
     */
    #[DataProvider("wrapperProvider")]
    public function testWrapperExtendsModel(string $wrapperClass, string $modelClass, string $fixture, callable $fetch): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/" . $fixture))]);

        $wrapper = $fetch($client);

        $this->assertInstanceOf($wrapperClass, $wrapper);
        $this->assertInstanceOf($modelClass, $wrapper);
        $this->assertFalse(method_exists($wrapper, "getData"));
        $this->assertEquals($this->createModel($fixture, $modelClass)->getId(), $wrapper->getId());
    }

    /**
     * @throws ApiException
     */
    #[DataProvider("wrapperProvider")]
    public function testWrapperIsSerializedLikeModel(string $wrapperClass, string $modelClass, string $fixture, callable $fetch): void
    {
        $client = $this->createClient([new Response(200, [], file_get_contents(__DIR__ . "/Fixtures/" . $fixture))]);

        $wrapper = $fetch($client);

        $this->assertJsonStringEqualsJsonString(
            json_encode($this->createModel($fixture, $modelClass)),
            json_encode($wrapper),
        );
        $this->assertStringNotContainsString("client", json_encode($wrapper));
    }
}
