<?php

namespace app\controllers;

use app\base\Controller;
use app\components\Debug;
use app\models\PreUsers;
use app\models\Users;

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
        $value  = $_POST['value'];
        $column = $_POST['type'];
        $available  = (new Users())->checkAvailability($column, $value);
        echo json_encode(["available" => $available]);
    }

    public function actionPreConfirm()
    {
        $userInput  = (array) json_decode($_POST['userInput']);

        print_r($userInput);

        $isValid = $this->checkUserInput($userInput);

        if (!$isValid)
            exit(json_encode(["success" => $isValid]));

        (new PreUsers())->insert($userInput);
    }

    private function checkUserInput($userInput)
    {
        $isValid = true;

        $isValid *= $this->isAvailable($userInput);

        return $isValid;
    }

    private function isAvailable($userInput)
    {
        $username   = $userInput['username'];
        $email      = $userInput['email'];

        $users = new Users();

        $available  = $users->checkAvailability('username', $username);
        $available *= $users->checkAvailability('email', $email);

        return $available;
    }
}
