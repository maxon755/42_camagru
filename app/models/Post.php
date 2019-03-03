<?php

namespace app\models;

use app\base\DataBaseModel;

class Post extends DataBaseModel
{
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

    /**
     * @param int $userId
     * @return int
     */
    public function getMaxImageNumber(int $userId): int
    {
        $res = $this->db->executeQuery('select max(number) from post where user_id = :userId', [
            'userId' => $userId
        ], true);

        return $res[0]['max'] ?? 0;
    }

    /**
     * @return array
     */
    public function getPosts(int $offset = null, int $limit = null): array
    {
        $imagePath = DS . self::$config['storage'] . DS . self::$config['imagesFolder'] . DS;

        $query = "SELECT
            c.username,
            c.user_id,
            p.image_name,
            '${imagePath}' || c.user_id || '/' || p.image_name AS image_path,
            to_char(p.creation_date, 'DD MonthYYYY HH:MM am') as date
        FROM post AS p
        JOIN client AS c ON c.user_id = p.user_id
        ORDER BY p.creation_date DESC";

        if ($offset) {
            $query = $query . ' ' . "OFFSET $offset";
        }
        if ($limit) {
            $query = $query . ' ' . "LIMIT $limit";
        }

        return $this->db->executeQuery($query);
    }
}
