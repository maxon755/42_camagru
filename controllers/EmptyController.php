<?php

namespace app\controllers;

use app\base\Controller;
use app\base\DataBase;
use app\components\Debug;

class EmptyController extends Controller
{
	public function actionIndex()
	{
//		echo "<br><code> Empty controller works and extends basic controller </code>";

		$this->render();
	}

	public function actionTestInsert()
    {
        $userInput = [
            "username"  => "Maxim",
            "password"  => 7777,
            "email"     => "maks@gmail.com",
            "firstName" => "Максим",
            "lastName"  => "Гайдук"
        ];

        $db = DataBase::getInstance('pre_users');

        Debug::debugArray($db->insert($userInput),"", true);
    }
}
