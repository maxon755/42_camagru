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
}