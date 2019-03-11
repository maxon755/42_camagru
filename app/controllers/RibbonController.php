<?php

namespace app\controllers;

use app\base\Controller;
use app\models\Comment;
use app\models\Post;
use app\models\PostLike;
use app\widgets\post\comment\Comment as CommentWidget;
use app\widgets\post\Post as PostWidget;


class RibbonController extends Controller
{
    /** @var Post  */
    private $postModel;

    private $commentModel;

    /** @var int */
    private $userId;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->commentModel = new Comment();
        $this->userId = self::$auth->getUserId();
    }

    public function actionIndex(): void
	{
		$this->render('ribbon', true);
	}

	public function actionGetPosts(): void
    {
        $offset = $_POST['offset'];
        $limit  = $_POST['limit'];

        $postsData = $this->postModel->getPosts($this->userId, $offset, $limit);

        foreach ($postsData as $postData) {
            $postData['comments'] = $this->commentModel->getComments([
                'post_id' => $postData['post_id']
            ]);
            (new PostWidget($postData, true))->render();
        }
    }

    public function actionToggleLike(): void
    {
        if (!$this->userId) {
            return;
        }
        $likeModel = new PostLike();
        $postId = $_POST['postId'];

        $response = [
            'likeAdded' => $likeModel->toggleLike($postId, $this->userId),
            'likeCount' => $likeModel->countLikes($postId),
        ];

        echo json_encode($response);
    }

    public function actionCreateComment(): void
    {
        if (!isset($_POST['postId']) || !isset($_POST['comment']) || !$_POST['comment']) {
            return;
        }

        $postId = $_POST['postId'];
        $comment = $_POST['comment'];

        $commentId = $this->commentModel->addComment($postId, $this->userId, $comment);
        $commentData = $this->commentModel->getComments(['comment_id' => $commentId])[0];

        (new CommentWidget($commentData, true))->render();
    }
}
