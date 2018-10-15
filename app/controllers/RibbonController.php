<?php

namespace app\controllers;

use app\base\Controller;
use app\components\Debug;

class RibbonController extends Controller
{
	public function actionIndex()
	{
//		echo "<br><code> Empty controller works and extends basic controller </code>";

//        Debug::debugArray(self::$components);

		$this->render('ribbon', true);
	}
}
