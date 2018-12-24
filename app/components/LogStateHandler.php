<?php

namespace app\components;


trait LogStateHandler
{
    public function login(string $username, int $days = 7): bool
    {
        return setcookie(
            'username',
            $username,
            time() + (3600 * 24 * $days),
            '/');
    }

    public function logout(): bool
    {
        return setcookie(
            'username',
            '',
            time() - 3600,
            '/');
    }
}