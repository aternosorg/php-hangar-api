<?php

namespace Aternos\HangarApi\Test\Unit\Client;

use Aternos\HangarApi\ApiException;
use Aternos\HangarApi\Client\HangarAPIClient;
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
}
