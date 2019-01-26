<?php

namespace app\base;


use app\models\AuthToken;
use app\models\Client;

class Auth
{
    private $username;
    private $userId;
    private $token;

    private $usernameClient;
    private $tokenClient;

    public function __construct()
    {
        $this->usernameClient = $_COOKIE['username'] ?? null;
        $this->tokenClient = $_COOKIE['token'] ?? null;

        if ($this->usernameClient && !$this->userId) {
            $this->fetchUserId($this->usernameClient);
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


        return  $this->setCookie('username', $this->username) &&
                $this->setCookie('token', $this->token);
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        return  $this->unsetCookie('username') &&
                $this->unsetCookie('token');
    }

    /**
     * @return null|string
     */
    public function getUserName(): ?string
    {
        return $this->username;
    }

    /**
     * @return bool
     */
    public function loggedIn(): bool
    {
        $this->fetchToken();
        return $this->clientDataExists() && $this->token === $this->tokenClient;
    }

    public function fetchToken(): void
    {
        if (!$this->token) {
            $this->token = (new AuthToken())->getValue('token', ['user_id' => $this->userId]);
        }
    }

    /**
     * @param string $username
     */
    public function fetchUserId(string $username): void
    {
        $this->userId = (new Client())->getValue('user_id', ['username' => $username]);
    }

    /**
     * @return bool
     */
    public function clientDataExists(): bool
    {
        return isset($this->usernameClient) && isset($this->tokenClient);
    }

    /**
     * @param string $name
     * @param string $value
     * @param int $days
     * @param string $path
     * @return bool
     */
    private function setCookie(string $name, string $value, int $days = 7, string $path = '/'): bool
    {
        return setcookie(
            $name,
            $value,
            time() + (3600 * 24 * $days),
            $path);
    }

    /**
     * @param string $name
     * @return bool
     */
    private function unsetCookie(string $name): bool
    {
        return setcookie(
            $name,
            '',
            time() - 3600,
            '/');
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

        return $username === $this->usernameClient && $this->token === $this->tokenClient;
    }
}
