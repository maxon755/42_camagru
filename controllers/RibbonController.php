<?php

namespace app\controllers;

use app\base\Controller;

class RibbonController extends Controller
{
	public function actionIndex()
	{
//		echo "<br><code> Empty controller works and extends basic controller </code>";

		$this->render('ribbon', true, [1, 42]);
	}
}
