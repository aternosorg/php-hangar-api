<?php

namespace Aternos\HangarApi\Test\Unit\Client;

use Aternos\HangarApi\Client\JWT;
use PHPUnit\Framework\TestCase;
use ReflectionProperty;

class JWTTest extends TestCase
{
    public function testGetToken(): void
    {
        $jwt = new JWT("token", 60 * 1000);

        $this->assertSame("token", $jwt->getToken());
    }

    public function testIsValidBeforeExpiration(): void
    {
        $jwt = new JWT("token", 60 * 60 * 1000);

        $this->assertTrue($jwt->isValid());
    }

    public function testIsInvalidWhenExpired(): void
    {
        $jwt = new JWT("token", 0);

        $this->assertFalse($jwt->isValid());
    }

    public function testExpiresInIsInterpretedAsMilliseconds(): void
    {
        // 999 milliseconds are less than a second, so the token is already expired.
        // If the value was interpreted as seconds, the token would still be valid.
        $jwt = new JWT("token", 999);

        $this->assertFalse($jwt->isValid());
    }

    public function testExpiresAtIsCalculatedInSeconds(): void
    {
        $before = time();
        $jwt = new JWT("token", 60 * 60 * 1000);
        $after = time();

        $expiresAt = (new ReflectionProperty(JWT::class, "expiresAt"))->getValue($jwt);

        $this->assertGreaterThanOrEqual($before + 60 * 60, $expiresAt);
        $this->assertLessThanOrEqual($after + 60 * 60, $expiresAt);
    }
}
