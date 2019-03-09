<?php

namespace app\controllers;

use app\base\Controller;
use app\models\Post;
use app\models\PostLike;
use app\widgets\post\Post as PostWidget;


class RibbonController extends Controller
{
    private $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function actionIndex(): void
	{
		$this->render('ribbon', true);
	}

	public function actionGetPosts(): void
    {
        $offset = $_POST['offset'];
        $limit  = $_POST['limit'];

        $postsData = $this->postModel->getPosts($offset, $limit);

        foreach ($postsData as $postData) {
            (new PostWidget($postData, true))->render();
        }
    }

    public function actionToggleLike(): void
    {
        $likeModel = new PostLike();

        $userId = self::$auth->getUserId();
        $postId = $_POST['postId'];

        $respose = [
            'likeAdded' => $likeModel->toggleLike($postId, $userId),
            'likeCount' => $likeModel->countLikes($postId),
        ];

        echo json_encode($respose);
    }
}
