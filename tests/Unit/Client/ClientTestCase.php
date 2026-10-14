<?php

namespace Aternos\HangarApi\Test\Unit\Client;

use Aternos\HangarApi\Client\HangarAPIClient;
use Aternos\HangarApi\Model\Pagination;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * Base class for unit tests that run against a mocked HTTP client.
 *
 * No test in this hierarchy may perform a real request, so every client is built
 * on a Guzzle MockHandler that answers with the given responses in order.
 */
abstract class ClientTestCase extends TestCase
{
    /**
     * Requests recorded by the history middleware of the most recent client
     * @var array<int, array{request: RequestInterface, response: mixed}>
     */
    protected array $requests = [];

    public function setUp(): void
    {
        $this->requests = [];
    }

    /**
     * Create a client that answers every request with one of the given responses, in order,
     * and records all requests in {@see $requests}
     * @param Response[] $responses
     * @return HangarAPIClient
     */
    protected function createClient(array $responses = []): HangarAPIClient
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $stack->push(Middleware::history($this->requests));
        return new HangarAPIClient(httpClient: new Client(['handler' => $stack]));
    }

    /**
     * Create an empty paginated result model, e.g. to create a result list without sending a request
     * @template T
     * @param class-string<T> $class generated model class, e.g. PaginatedResultUser
     * @param int $offset
     * @return T
     */
    protected function createPaginatedResult(string $class, int $offset = 0): mixed
    {
        return new $class([
            "pagination" => new Pagination(["count" => 10, "limit" => 2, "offset" => $offset]),
            "result" => [],
        ]);
    }

    /**
     * Get a request recorded by the history middleware
     * @param int $index
     * @return RequestInterface
     */
    protected function getRequest(int $index = 0): RequestInterface
    {
        $this->assertArrayHasKey($index, $this->requests, "Request " . $index . " was not sent");
        return $this->requests[$index]['request'];
    }

    /**
     * Get the query parameters of a recorded request
     * @param int $index
     * @return array<string, string|string[]>
     */
    protected function getQuery(int $index = 0): array
    {
        $query = [];
        foreach (explode("&", $this->getRequest($index)->getUri()->getQuery()) as $pair) {
            if ($pair === "") {
                continue;
            }
            [$key, $value] = array_map("urldecode", explode("=", $pair, 2) + [1 => ""]);
            if (array_key_exists($key, $query)) {
                $query[$key] = [...(array)$query[$key], $value];
            } else {
                $query[$key] = $value;
            }
        }
        return $query;
    }

    /**
     * Assert that a recorded request is a GET request to the given path that contains the given query parameters
     * @param string $path path without the /api/v1 prefix
     * @param array<string, string|string[]> $query expected query parameters, other parameters are ignored
     * @param int $index
     * @return void
     */
    protected function assertGetRequest(string $path, array $query = [], int $index = 0): void
    {
        $request = $this->getRequest($index);
        $this->assertSame("GET", $request->getMethod());
        $this->assertSame("/api/v1" . $path, $request->getUri()->getPath());

        $actualQuery = $this->getQuery($index);
        foreach ($query as $key => $value) {
            $this->assertArrayHasKey($key, $actualQuery, "Query parameter " . $key . " is missing");
            $this->assertSame($value, $actualQuery[$key], "Query parameter " . $key . " has the wrong value");
        }
    }

    /**
     * Assert the number of requests that were sent
     * @param int $count
     * @return void
     */
    protected function assertRequestCount(int $count): void
    {
        $this->assertCount($count, $this->requests);
    }
}
