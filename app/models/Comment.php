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

    public function getComments(array $whereData)
    {
        $query = "SELECT
            comment_id,
            cl.username as username,
            creation_date,
            comment
            FROM comment cm
            JOIN client  cl ON cl.user_id = cm.user_id
        ";

        $query .= ' WHERE ' . $this->prepareWhereData($whereData);
        return $this->db->executeQuery($query);
    }
}