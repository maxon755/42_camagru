<?php

namespace app\controllers;

use app\base\Controller;

class EmptyController extends Controller
{
	public function actionIndex()
	{
		echo "<br><code> Empty controller works and extends basic controller </code>";
	}
}
