<?php

namespace Tomgrohl\Laravel\Auth\Tests;

use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Hashing\Hasher;
use Tomgrohl\Laravel\Auth\InMemoryUserProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class InMemoryUserProviderTest
 *
 * @package Tomgrohl\Laravel\Auth\Tests
 */
class InMemoryUserProviderTest extends TestCase
{
    public function testProviderRetrieveById()
    {
        $hasher = $this->createMock(Hasher::class);

        $provider = $this->getProvider($hasher);

        $this->assertInstanceOf(GenericUser::class, $provider->retrieveById(1));
        $this->assertNull($provider->retrieveById(2));
    }

    public function testProviderRetrieveByToken()
    {
        $hasher = $this->createMock(Hasher::class);

        $provider = $this->getProvider($hasher);

        $this->assertInstanceOf(GenericUser::class, $provider->retrieveByToken(1, 'token'));
        $this->assertNull($provider->retrieveByToken(1, 'non_existent_token'));
        $this->assertNull($provider->retrieveByToken(2, 'non_existent_token'));
    }

    public function testProviderUpdateRememberToken()
    {
        $hasher = $this->createMock(Hasher::class);

        $provider = $this->getProvider($hasher);

        $user = $provider->retrieveById(1);

        $provider->updateRememberToken($user, 'updated_token');
        $this->assertInstanceOf(GenericUser::class, $provider->retrieveByToken(1, 'updated_token'));
    }

    public function testProviderRetrieveByCredentials()
    {
        $hasher = $this->createMock(Hasher::class);

        $provider = $this->getProvider($hasher);

        $this->assertInstanceOf(GenericUser::class, $provider->retrieveByCredentials([
            'username' => 'admin'
        ]));

        $this->assertNull($provider->retrieveByCredentials([
            'username' => 'foo'
        ]));
    }

    public function testProviderValidateCredentials()
    {
        $hasher = $this->createMock(Hasher::class);

        $hasher->expects($this->once())
            ->method('check')
            ->will($this->returnValue(true))
        ;

        $user = $this->createMock(GenericUser::class);
        $provider = $this->getProvider($hasher);

        $this->assertTrue($provider->validateCredentials($user, [
            'username' => 'admin',
            'password' => 'password',
        ]));
    }

    /**
     * @param $hasher
     * @return InMemoryUserProvider
     */
    protected function getProvider($hasher)
    {
        return new InMemoryUserProvider($hasher, [
            'admin' => [
                'id' => 1,
                'password' => 'sdfsfdsdfsfdsf',
                'remember_token' => 'token',
            ]
        ]);
    }

}
