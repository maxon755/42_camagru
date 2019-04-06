<?php

namespace app\controllers;

use app\base\Controller;
use app\base\Widget;
use app\components\Mailer;
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

	public function actionGetPosts(string $username = null): void
    {
        $offset = $_POST['offset'];
        $limit  = $_POST['limit'];

        if (!isset($offset) || !is_numeric($offset) ||
            !isset($limit)  || !is_numeric($limit)) {
            echo $this->jsonResponse(false);
            return;
        }

        $postModel = new Post();
        $postsData = $postModel->getPosts($this->userId, array_filter([
            'is_deleted' => 'false',
            'username'   => $username,
        ]), $offset, $limit);

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
            return;
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

        if (!isset($this->userId) || !isset($postId) || !is_numeric($postId)) {
            echo $this->jsonResponse(false);
            return;
        }
        $likeModel = new PostLike();

        echo $this->jsonResponse(true, [
            'liked' => $likeModel->toggleLike($postId, $this->userId),
            'likeCount' => $likeModel->countLikes($postId),
        ]);
    }

    public function actionCreateComment(): void
    {
        $postId = $_POST['postId'];
        $comment = $_POST['comment'];

        if (!isset($this->userId) || !isset($postId) || !is_numeric($postId) || !isset($comment)) {
            echo $this->jsonResponse(false);
            return;
        }

        $commentModel = new Comment();

        $commentId = $commentModel->addComment($postId, $this->userId, $comment);
        $commentData = $commentModel->getComments(['comment_id' => $commentId])[0];
        $shouldNotify = $commentModel->shouldNotify($commentId, 'comment');

        echo $this->jsonResponse($commentId, [
            'commentId'     => $commentData['comment_id'],
            'shouldNotify'  => $shouldNotify,
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
            return;
        }

        $commentModel = new Comment();

        $commentOwnerId = $commentModel->getCommentOwnerId($commentId);
        if ($this->userId !== $commentOwnerId) {
            echo $this->jsonResponse(false);
        }

        echo $this->jsonResponse($commentModel->deleteComment($commentId));
    }

    public function actionUser(string $username): void
    {
        $this->render('ribbon', true, ['username' => $username]);
    }

    public function actionCommentNotify()
    {
        $commentId = $_POST['commentId'];

        if (!isset($commentId) || !is_numeric($commentId)) {
            echo $this->jsonResponse(false);
            return;
        }

        $commentModel = new Comment();
        $data = $commentModel->getCommentNotificationData([
            'comment_id' => $commentId
        ])[0];

        if ($data['comment_writer'] === $data['post_owner']) {
            echo $this->jsonResponse(false);
            return;
        }

        echo $this->jsonResponse($this->sendCommentNotificationEmail($data));
    }

    /**
     * @param array $data
     * @return bool
     */
    private function sendCommentNotificationEmail(array $data): bool
    {
        $email          = $data['email'];
        $commentWriter  = $data['comment_writer'];
        $postOwner      = $data['post_owner'];
        $commentText    = $data['comment_text'];
        $body = include(ROOT . DS . 'mails/comment.php');

        return (new Mailer())->sendEmail(
            $email,
            'Comment Notification',
            $body
        );
    }
}
