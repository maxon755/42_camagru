<?php

namespace app\controllers;

use app\base\Controller;
use app\base\Widget;
use app\models\Comment;
use app\models\Post;
use app\models\PostLike;
use app\widgets\post\comment\Comment as CommentWidget;
use app\widgets\post\Post as PostWidget;


class RibbonController extends Controller
{
    /** @var Post  */
    private $postModel;

    /** @var Comment  */
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

        if (!isset($offset) || !is_numeric($offset) ||
            !isset($limit)  || !is_numeric($limit)) {
            return;
        }

        $postsData = $this->postModel->getPosts($this->userId, $offset, $limit);

        foreach ($postsData as $postData) {
            $postData['comments'] = $this->commentModel->getComments([
                'post_id' => $postData['post_id']
            ]);
            (new PostWidget($postData, true))->render();
        }
    }

    public function deletePost(): void
    {

    }

    public function actionToggleLike(): void
    {
        $postId = $_POST['postId'];

        if (!$this->userId || !isset($postId) || !is_numeric($postId)) {
            echo $this->jsonResponse(false);
        }
        $likeModel = new PostLike();

        echo $this->jsonResponse($likeModel->toggleLike($postId, $this->userId), [
            'likeCount' => $likeModel->countLikes($postId),
        ]);
    }

    public function actionCreateComment(): void
    {
        $postId = $_POST['postId'];
        $comment = $_POST['comment'];

        if (!isset($postId) || !is_numeric($postId) || !isset($comment)) {
            echo $this->jsonResponse(false);
        }

        $commentId = $this->commentModel->addComment($postId, $this->userId, $comment);
        $commentData = $this->commentModel->getComments(['comment_id' => $commentId])[0];

        echo $this->jsonResponse($commentId, [
            'commentId'     => $commentData['comment_id'],
            'shouldNotify'  => $commentData['comment_notify'],
            'comment'       => Widget::getContent(
                (new CommentWidget($commentData, true))
            )
        ]);
    }

    public function actionDeleteComment(): void
    {
        $commentId = $_POST['commentId'];

        if (!isset($commentId) || !is_numeric($commentId)) {
            echo $this->jsonResponse(false);
        }

        $currentUserId = self::$auth->getUserId();
        $postOwnerId = $this->commentModel->getCommentOwnerId($commentId);
        if ($currentUserId !== $postOwnerId) {
            echo $this->jsonResponse(false);
        }

        echo $this->jsonResponse($this->commentModel->deleteComment($commentId));
    }

    public function actionCommentNotify()
    {
        $commentId = $_POST['commentId'];

        if (!isset($commentId) || !is_numeric($commentId)) {
            return;
        }

    }
}
