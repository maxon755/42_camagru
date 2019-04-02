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
        $res = $this->db->select('select max(number) from post', [
            'user_id' => $userId,
        ]);

        return $res[0]['max'] ?? 0;
    }

    /**
     * @param int $postId
     * @return int
     */
    public function getPostOwnerId(int $postId): int
    {
        return $this->getValue('user_id', [
            'post_id' => $postId,
        ]);
    }

    /**
     * @param int $postId
     * @return string
     */
    public function getPostImagePath(int $postId): string
    {
        $res = $this->db->selectWhere([
            'post_id' => $postId,
        ])[0];

        $imagePath = ROOT . $this->getImagePath() . $res['user_id'] . DS . $res['image_name'];

        return $imagePath;
    }

    /**
     * @param int|null $currentUserId
     * @param int|null $offset
     * @param int|null $limit
     * @return array
     */
    public function getPosts(?int $currentUserId, array $where = [], int $offset = null, int $limit = null): array
    {
        $currentUserId = $currentUserId ?? 'null';
        $imagePath = $this->getImagePath();

        $query = "SELECT
            p.post_id,
            c.username,
            c.user_id,
            p.image_name,
            count(l.*)  AS likes,
            count(ul.*) AS liked,
            '${imagePath}' || c.user_id || '/' || p.image_name AS image_path,
            to_char(p.creation_date, 'DD MonthYYYY HH:MM am') AS date,
            MD5(TRIM(c.email)) AS email_hash
        FROM post AS p
        JOIN client AS c ON c.user_id = p.user_id
        LEFT JOIN post_like AS l ON l.post_id = p.post_id
        LEFT JOIN post_like AS ul ON ul.post_id = p.post_id AND ul.client_id = $currentUserId";

        return $this->db->select($query, $where, [
            'p.post_id',
            'c.user_id'
        ], [
            'p.creation_date' => 'DESC',
        ], $offset, $limit);
    }

    /**
     * @param int $postId
     * @return bool
     */
    public function deletePost(int $postId): bool
    {
        return $this->db->update([
            'is_deleted' => true,
        ], [
            'post_id' => $postId,
        ]);
    }

    private function getImagePath()
    {
        return DS . self::$config['storage'] . DS . self::$config['imagesFolder'] . DS;
    }
}
