<?php

namespace app\models;

use app\base\DataBaseModel;

class Post extends DataBaseModel
{
    public static function getClassName(): string
    {
        return __CLASS__;
    }

    /**
     * @param int $userId
     * @param string $name
     * @param int $number
     * @return bool
     */
    public function insertImageData(int $userId, string $name, int $number): bool
    {
        return $this->db->insertIfNotExists([
            'user_id'       => $userId,
            'image_name'    => $name,
            'number'        => $number,
        ], [
            'user_id'       => $userId,
            'image_name'    => $name,
        ]);
    }

    public function getMaxImageNumber($userId)
    {
        $res = $this->db->executeQuery('select max(number) from post where user_id = :userId', [
            'userId' => $userId
        ], true);

        return $res[0]['max'] ?? 0;
    }
}