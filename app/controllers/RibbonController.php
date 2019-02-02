<?php

namespace app\controllers;

use app\base\Controller;
use app\components\Debug;
use app\models\Post;

class RibbonController extends Controller
{
	public function actionIndex()
	{
	    $postModel = new Post();
        $postsData = $postModel->getPosts();

//        $postData['image_path'] = self::$config['storage'] . DS . self::$config['image_folder'] . $postData
        var_dump($postsData);

		$this->render('ribbon', true, $postsData);
	}
}
