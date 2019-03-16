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
    /** @var int */
    private $userId;

    public function __construct()
    {
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

        $postModel = new Post();
        $postsData = $postModel->getPosts($this->userId, [
            'is_deleted' => 'false',
        ], $offset, $limit);

        $commentModel = new Comment();
        $posts = [];
        foreach ($postsData as $postData) {
            $postId = $postData['post_id'];
            $postData['comments'] = $commentModel->getComments([
                'post_id' => $postId
            ]);
            $post['postId'] = $postId;
            $post['post'] = Widget::getContent(
                new PostWidget($postData, true)
            );

            $posts[] = $post;
        }

        echo $this->jsonResponse(!empty($posts), [ 'posts' => $posts ]);
    }

    public function actionDeletePost(): void
    {
        $postId = $_POST['postId'];

        if (!$this->userId || !isset($postId) || !is_numeric($postId)) {
            echo $this->jsonResponse(false);
        }

        $postModel = new Post();
        $postOwnerId = $postModel->getPostOwnerId($postId);

        if ($this->userId !== $postOwnerId) {
            echo $this->jsonResponse(false);
        }

        echo $this->jsonResponse($postModel->deletePost($postId));
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

        $commentModel = new Comment();

        $commentId = $commentModel->addComment($postId, $this->userId, $comment);
        $commentData = $commentModel->getComments(['comment_id' => $commentId])[0];

        echo $this->jsonResponse($commentId, [
            'commentId'     => $commentData['comment_id'],
            'shouldNotify'  => $commentData['comment_notify'],
            'comment'       => Widget::getContent(
                new CommentWidget($commentData, true)
            )
        ]);
    }

    public function actionDeleteComment(): void
    {
        $commentId = $_POST['commentId'];

        if (!isset($this->userId)|| !isset($commentId) || !is_numeric($commentId)) {
            echo $this->jsonResponse(false);
        }

        $commentModel = new Comment();

        $commentOwnerId = $commentModel->getCommentOwnerId($commentId);
        if ($this->userId !== $commentOwnerId) {
            echo $this->jsonResponse(false);
        }

        echo $this->jsonResponse($commentModel->deleteComment($commentId));
    }

    public function actionCommentNotify()
    {
        $commentId = $_POST['commentId'];

        if (!isset($commentId) || !is_numeric($commentId)) {
            return;
        }

    }
}
