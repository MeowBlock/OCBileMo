<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class UserTest extends ApiTestCase
{
    protected function restoreExceptionHandler(): void
    {
        while (true) {
            $previousHandler = set_exception_handler(static fn() => null);
        
            restore_exception_handler();
        
            if ($previousHandler === null) {
                break;
            }
        
            restore_exception_handler();
        }
    }
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->restoreExceptionHandler();
    }
    public function testNoJwt(): void
    {
        $response = static::createClient()->request('GET', '/api/users');

        $this->assertResponseStatusCodeSame(401, 'JWT Token not found');
    }
}
