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

    public function actionCheckAvailability()
    {
        $value      = $_POST['value'];
        $columnName = $_POST['type'];

        $db = DataBase::getInstance('users');

        $data = $db->selectAllWhere($columnName, $value);
        echo json_encode(["available" => !count($data)]);
    }

    public function actionPreConfirm()
    {
        $userInput  = (array) json_decode($_POST['userInput']);
        $db         = DataBase::getInstance('pre_users');
        $db->insert($userInput);
    }
}
