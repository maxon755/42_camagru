<?php

namespace app\models;

use app\base\DataBaseModel;

class PostLike extends DataBaseModel
{
    public function countLikes(int $postId)
    {
        return $this->db->count([
            'post_id'   => $postId,
        ]);
    }

    /**
     * @param int $postId
     * @param int $userId
     * @return bool
     */
    public function toggleLike(int $postId, int $userId): bool
    {
        $data = [
            'post_id'   => $postId,
            'client_id' => $userId,
        ];
        $shouldAdd = !$this->db->rowExists($data);

        if ($shouldAdd) {
            $this->db->insert($data);
        } else {
            $this->db->delete($data);
        }

        return $shouldAdd;
    }

    /**
     * @param int $postId
     * @return bool
     */
    public function shouldNotify(int $postId): bool
    {
        return $this->db->select('SELECT
            c.like_notify
            FROM post AS p
            JOIN client as c ON p.user_id = c.user_id
        ', ['post_id' => $postId])[0]['like_notify'];
    }

    /**
     * @param int $postId
     * @return array
     */
    public function getLikeNotificationData(int $postId): array
    {
        return $this->db->select('SELECT
            c.username AS post_owner,
            c.email AS email
            FROM post AS p
            JOIN client c on p.user_id = c.user_id',
            ['post_id' => $postId])[0];
    }
}
