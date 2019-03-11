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
    public function getComments(array $whereData): array
    {
        $whereString = $this->prepareWhereData($whereData);

        $query = "SELECT
            comment_id,
            cl.username,
            to_char(creation_date, 'DD MonthYYYY HH:MM am') AS date,
            comment
            FROM comment cm
            JOIN client  cl ON cl.user_id = cm.user_id
            WHERE $whereString
            ORDER BY creation_date DESC
        ";

        return $this->db->executeQuery($query);
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
}