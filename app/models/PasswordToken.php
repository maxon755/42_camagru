<?php


namespace app\models;


use app\base\DataBaseModel;

class PasswordToken extends DataBaseModel
{
    /**
     * @param int $userId
     * @param string $token
     * @return bool
     */
    public function insertToken(int $userId, string $token): bool
    {
        if (!$this->rowExists(['user_id' => $userId])) {
            return $this->db->insert([
                'user_id' => $userId,
                'token' => $token,
            ]);
        } else {
            return $this->db->update(['token' => $token], ['user_id' => $userId]);
        }
    }
}
