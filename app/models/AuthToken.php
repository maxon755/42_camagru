<?php

namespace app\models;

use app\base\DataBaseModel;

class AuthToken extends DataBaseModel
{
    public static function getClassName(): string
    {
        return __CLASS__;
    }

    public function insertToken(int $userId, string $token)
    {
        if (!$this->rowExists(['user_id' => $userId])) {
            return $this->db->insert([
                'user_id'   => $userId,
                'token'     => $token,
            ]);
        } else {
            return $this->db->update(['token' => $token], ['user_id' => $userId]);
        }
    }
}