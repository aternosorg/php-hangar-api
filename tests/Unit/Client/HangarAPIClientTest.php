<?php

namespace Aternos\HangarApi\Test\Unit\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
use Composer\InstalledVersions;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class HangarAPIClientTest extends TestCase
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
        $history = [];
        $client = new HangarAPIClient(httpClient: $this->createHttpClient($history));

        $client->getLatestReleaseVersion("mclogs");

        $this->assertEquals(HangarAPIClient::getDefaultUserAgent(), $history[0]['request']->getHeaderLine("User-Agent"));
    }

    /**
     * @throws ApiException
     */
    public function testUserAgentFromConstructorReplacesDefaultUserAgent(): void
    {
        $history = [];
        $client = new HangarAPIClient(httpClient: $this->createHttpClient($history), userAgent: "test-agent/1.0");

        $client->getLatestReleaseVersion("mclogs");

        $this->assertEquals("test-agent/1.0", $history[0]['request']->getHeaderLine("User-Agent"));
    }

    /**
     * @throws ApiException
     */
    public function testSetUserAgentReplacesDefaultUserAgent(): void
    {
        $history = [];
        $client = new HangarAPIClient(httpClient: $this->createHttpClient($history));

        $this->assertSame($client, $client->setUserAgent("test-agent/1.0"));
        $client->getLatestReleaseVersion("mclogs");

        $this->assertEquals("test-agent/1.0", $history[0]['request']->getHeaderLine("User-Agent"));
    }

    /**
     * Create an HTTP client that answers with a plain text version string and records all requests
     *
     * @param array $history
     * @return Client
     */
    protected function createHttpClient(array &$history): Client
    {
        $handlerStack = HandlerStack::create(new MockHandler([
            new Response(200, [], "1.0.0"),
        ]));
        $handlerStack->push(Middleware::history($history));
        return new Client(['handler' => $handlerStack]);
    }
}
