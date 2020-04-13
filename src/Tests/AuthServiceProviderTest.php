<?php

namespace Tomgrohl\Laravel\Auth\Tests;

use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Application;
use Tomgrohl\Laravel\Auth\AuthServiceProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class AuthServiceProviderTest
 *
 * @package Tomgrohl\Laravel\Auth\Tests
 */
class AuthServiceProviderTest extends TestCase
{
    public function testProvider()
    {
        $authManager = $this->createMock(AuthManager::class);

        $authManager->expects($this->once())
            ->method('extend');

        $app = new Application();
        $app['auth'] = $authManager;
        $provider = new AuthServiceProvider($app);

        $app->register($provider);
    }
}
