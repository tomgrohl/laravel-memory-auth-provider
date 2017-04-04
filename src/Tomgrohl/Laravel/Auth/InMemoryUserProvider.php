<?php

namespace Tomgrohl\Laravel\Auth;

use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider as BaseUserProvider;

class InMemoryUserProvider implements BaseUserProvider
{
    /**
     * @var array
     */
    protected $users;

    /**
     * @var HasherContract
     */
    protected $hasher;

    public function __construct(HasherContract $hasher, array $users)
    {
        $this->hasher = $hasher;
        $this->users = $users;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        foreach ($this->users as $username => $fields) {
            if ($fields['id'] === $identifier) {
                return $this->getGenericUser($username, $this->users[$username]);
            }
        }

        return null;
    }

    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param  mixed $identifier
     * @param  string $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        if ( ! $user = $this->retrieveById($identifier)) {
            return null;
        }

        if ($token === $user->getRememberToken()) {
            return $user;
        }

        return null;
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        $this->users[$user->username][$user->getRememberTokenName()] = $token;
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $username = $credentials['username'];

        if ( ! isset($this->users[$username])) {
            return null;
        }

        return $this->getGenericUser($username, $this->users[$username]);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $plain = $credentials['password'];

        return $this->hasher->check($plain, $user->getAuthPassword());
    }

    /**
     * Get the generic user.
     *
     * @param string $username
     * @param array $fields
     * @return GenericUser
     */
    protected function getGenericUser($username, array $fields = [])
    {
        $fields['username'] = $username;
        return new GenericUser($fields);
    }
}
