<?php

namespace app\controllers;

use app\base\Controller;
use app\components\Debug;
use app\components\InputField;
use app\models\PreUsers;
use app\models\Users;

class SignUpController extends Controller
{
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
//        $userInput  = (array) json_decode($_POST['userInput']);
//        $userInput  = $_POST;

        $userInput = [
            'username'          => 'mgayduk',
            'first-name'        => 'maks',
            'last-name'         => 'gayduk',
            'email'             => 'maksim.gayduk@gmail.com',
            'password'          => '1234aaZZ',
            'repeat-passwordd'  => '1234aaZZ',
        ];

        print_r($userInput);

        $isValid = $this->checkUserInput($userInput);

//        if (!$isValid)
//            exit(json_encode(["success" => $isValid]));

//        (new PreUsers())->insert($userInput);
    }

    private function checkUserInput($userInput)
    {
        $i = new InputField('username', 'maks', [
           'emptyness',
           'word'
        ]);

        print_r($i);

//        $isValid = true;
//        $isValid *= $this->isAvailable($userInput);
//        return $isValid;
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
