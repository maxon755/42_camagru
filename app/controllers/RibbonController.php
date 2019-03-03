<?php

namespace app\controllers;

use app\base\Controller;
use app\models\Post;
use app\widgets\post\Post as PostWidget;


class RibbonController extends Controller
{
    private $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function actionIndex()
	{
		$this->render('ribbon', true);
	}

	public function actionGetPosts()
    {
        $offset = $_POST['offset'];
        $limit  = $_POST['limit'];

        $postsData = $this->postModel->getPosts($offset, $limit);

        $posts = [];
        foreach ($postsData as $postData) {
            (new PostWidget($postData))->render();
        }
    }
}
