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
    private $userIdClient;
    private $tokenClient;

    public function __construct()
    {
        $this->usernameClient = $_COOKIE['username'] ?? null;
        $this->userIdClient = $_COOKIE['user_id'] ?? null;
        $this->tokenClient = $_COOKIE['token'] ?? null;
    }

    /**
     * @param string $username
     * @return bool
     */
    public function login(string $username): bool
    {
        $this->username = $username;
        $this->userId = (new Client())->getValue('user_id', ['username' => $username]);
        $this->token = $this->manageToken();


        return  $this->setCookie('username', $this->username) &&
                $this->setCookie('user_id', $this->userId) &&
                $this->setCookie('token', $this->token);
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        return  $this->unsetCookie('username') &&
                $this->unsetCookie('user_id') &&
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
        $this->getToken();
        return $this->clientDataExists() && $this->token === $this->tokenClient;
    }

    public function getToken()
    {
        if (!$this->token) {
            $this->token = (new AuthToken())->getValue('token', ['user_id' => $this->userIdClient]);
        }
    }

    /**
     * @return bool
     */
    public function clientDataExists(): bool
    {
        return isset($this->userIdClient) && isset($this->usernameClient) && isset($this->tokenClient);
    }

    /**
     * @param $name
     * @param $value
     * @param int $days
     * @param string $path
     * @return bool
     */
    private function setCookie($name, $value, $days = 7, $path = '/'): bool
    {
        return setcookie(
            $name,
            $value,
            time() + (3600 * 24 * $days),
            $path);
    }

    /**
     * @param $name
     * @return bool
     */
    private function unsetCookie($name): bool
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
        $this->getToken();

        return $username === $this->usernameClient && $this->token === $this->tokenClient;
    }
}