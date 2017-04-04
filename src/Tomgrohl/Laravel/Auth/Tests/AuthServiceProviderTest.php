<?php

namespace Tomgrohl\Laravel\Auth\Tests;

use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Application;
use PHPUnit_Framework_TestCase;
use Tomgrohl\Laravel\Auth\AuthServiceProvider;

/**
 * Class AuthServiceProviderTest
 *
 * @package Tomgrohl\Laravel\Auth\Tests
 */
class AuthServiceProviderTest extends PHPUnit_Framework_TestCase
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
