<?php

namespace app\controllers;

use app\base\Controller;
use app\components\Debug;
use app\components\InputChecker;
use app\components\InputField;
use app\components\InputForm;
use app\models\PreUsers;
use app\models\Users;

class SignUpController extends Controller
{
    private $signUpForm;

    public function __construct()
    {
        $this->signUpForm = new InputForm('sign_up', [
            'username' => ['emptiness', 'length', 'word'],
            'email'=> ['emptiness', 'length']
        ]);
    }

    public function actionIndex($parameters=[])
    {
        $this->render('sign-up', false, $parameters);
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
            'username'          => 'pan_Z',
            'first-name'        => 'maks',
            'last-name'         => 'gayduk',
            'email'             => 'maksim.gayduk@gmail.com',
            'password'          => '1234aaZZ',
            'repeat-passwordd'  => '1234aaZZ',
        ];

//        print_r($userInput);
        print_r($this->signUpForm);

        $isValid = $this->checkUserInput($userInput);

//        if (!$isValid)
//            exit(json_encode(["success" => $isValid]));

//        (new PreUsers())->insert($userInput);
    }

    private function checkUserInput($userInput)
    {
        $inputFields = $this->getInputFields($userInput);
//        print_r($inputFields);

        (new InputChecker($inputFields))->check();

//        print_r($inputFields);

        $this->actionIndex(['signUpForm' => $this->signUpForm]);
//        $isValid = true;
//        $isValid *= $this->isAvailable($userInput);
//        return $isValid;
    }

    private function getInputFields(array $userInput): array
    {
        return [
            'username' => new InputField('username', $userInput['username'], [
                'emptiness',
                'length',
                'word'
            ])
        ];
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
