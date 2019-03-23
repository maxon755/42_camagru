<?php

namespace app\base;


use app\components\Cookie;
use app\models\AuthToken;
use app\models\Client;

class Auth
{
    /** @var string  */
    private $username;

    /** @var int */
    private $userId;

    /** @var string */
    private $token;

    public function __construct()
    {
        $this->username = Cookie::get('username');

        if ($this->username && !$this->userId) {
            $this->fetchUserId($this->username);
        }
    }

    /**
     * @param string $username
     * @return bool
     */
    public function login(string $username): bool
    {
        $this->username = $username;
        $this->fetchUserId($username);
        $this->token = $this->manageToken();

        return  Cookie::set('username', $this->username) &&
                Cookie::set('token', $this->token);
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        return  Cookie::unset('username') &&
                Cookie::unset('token');
    }

    /**
     * @return null|string
     */
    public function getUserName(): ?string
    {
        return $this->username;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return bool
     */
    public function loggedIn(): bool
    {
        $this->fetchToken();
        return $this->clientDataExists() && $this->token === Cookie::get('token');
    }

    public function fetchToken(): void
    {
        if (!$this->token) {
            $this->token = (new AuthToken())->getValue('token', [
                'user_id' => $this->userId
            ]);
        }
    }

    /**
     * @param string $username
     */
    public function fetchUserId(string $username): void
    {
        $this->userId = (new Client())->getValue('user_id', [
            'username' => $username
        ]);
    }

    /**
     * @return bool
     */
    public function clientDataExists(): bool
    {
        return Cookie::get('username') && Cookie::get('token');
    }

    /**
     * @return string
     */
    private function manageToken(): string
    {
        $token = password_hash($this->username . time(), PASSWORD_BCRYPT);
        (new AuthToken())->insertToken($this->userId, $token);

        return $token;
    }

    /**
     * @param string $username
     * @return bool
     */
    public function selfPage(string $username): bool
    {
        $this->fetchToken();

        return $username === Cookie::get('username') && $this->token === Cookie::get('token');
    }
}
