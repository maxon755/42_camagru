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
        $whereString = $this->prepareWhereData($whereData);

        $query = "SELECT
            comment_id,
            cl.username AS user,
            to_char(creation_date, 'DD MonthYYYY HH:MM am') AS date,
            comment
            FROM comment cm
            JOIN client  cl ON cl.user_id = cm.user_id
            WHERE $whereString
            ORDER BY creation_date DESC
        ";

        return $this->db->executeQuery($query);
    }
}