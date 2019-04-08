<?php

namespace app\models;


use app\base\DataBaseModel;

class Comment extends DataBaseModel
{
    public function addComment(int $postId, int $userId, string $comment)
    {
        $res = $this->db->insert([
            'post_id' => $postId,
            'user_id' => $userId,
            'comment' => $comment,
        ], 'comment_id');

        return $res;
    }

    /**
     * @param array $whereData
     * @return array
     */
    public function getComments(array $where): array
    {
        $query = "SELECT
            comment_id,
            cl.username,
            to_char(creation_date, 'DD MonthYYYY HH:MM am') AS date,
            comment
            FROM comment cm
            JOIN client  cl ON cl.user_id = cm.user_id
        ";

        return $this->db->select($query, $where, [], [
            'creation_date' => 'DESC',
        ]);
    }

    /**
     * @param int $commentId
     * @return int|null
     */
    public function getCommentOwnerId(int $commentId): ?int
    {
        return $this->getValue('user_id', [
            'comment_id' => $commentId,
        ]);
    }

    /**
     * @param int $commentId
     * @return bool
     */
    public function deleteComment(int $commentId): bool
    {
        return $this->db->delete([
            'comment_id' => $commentId,
        ]);
    }

    public function getCommentNotificationData(array $where): array
    {
        return $this->db->select('
            SELECT po.email AS email, po.username AS post_owner,
                   cw.username AS comment_writer,
                   cm.comment AS comment_text
            FROM comment AS cm
            JOIN client AS cw ON cw.user_id = cm.user_id
            JOIN post AS p ON p.post_id = cm.post_id
            JOIN client AS po ON po.user_id = p.user_id',
            $where
        );
    }

    public function shouldNotify(int $commentId): bool
    {
        return $this->db->select('SELECT
            c.comment_notify
            FROM comment AS cm
            JOIN post p on cm.post_id = p.post_id
            JOIN client c on p.user_id = c.user_id
        ', ['comment_id' => $commentId])[0]['comment_notify'];
    }
}
