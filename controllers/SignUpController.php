<?php

namespace app\controllers;

use app\base\Controller;
use app\base\DataBase;
use app\components\Debug;

class SignUpController extends Controller
{
    public function actionConfirm() {
        echo "method works!";
    }

    public function actionIndex()
    {
        $this->render('sign-up', false);
    }

    public function actionCheckUsername()
    {
        $username = $_POST['username'];

        $db = new DataBase('users');
        $data = $db->selectAllWhere('username', $username);
        echo json_encode(["available" => !count($data)]);
    }

    public function actionCheckEmail()
    {
        $username = $_POST['email'];

        $db = new DataBase('users');
        $data = $db->selectAllWhere('email', $username);
        echo json_encode(["available" => !count($data)]);
    }
}
