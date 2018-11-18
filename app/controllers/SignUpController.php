<?php

namespace app\controllers;

use app\base\Controller;
use app\components\Debug;
use app\components\inputForm\InputChecker;
use app\components\inputForm\InputField;
use app\components\inputForm\InputForm;
use app\components\Mailer;
use app\models\User;

class SignUpController extends Controller
{
    private $signUpForm;

    const VIEW_NAME = 'sign-up';

    public function __construct()
    {
        $this->signUpForm = new InputForm('sign_up', 'Sign Up', '/sign-up/confirm', 'post', [
            'username'  => new InputField('username', 'text', true, [
                'emptiness',
                'length',
                'word'
            ], true),
            'first-name'=> new InputField('first-name', 'text', false, [
                'length'
            ]),
            'last-name' => new InputField('last-name', 'text', false, [
                'length'
            ]),
            'email'     => new InputField('email', 'email', true, [
                'emptiness',
                'length',
                'email'
            ], true),
            'password'  => new InputField('password', 'password', true, [
                'emptiness',
                'length',
                'password'
            ]),
            'repeat-password' => new InputField('repeat-password', 'password', true, [
                'emptiness',
                'length',
                'equality'
            ], false, null, $auxValue = 'password')
        ]);
    }

    private function renderForm()
    {
        $this->render(self::VIEW_NAME, false, ['signUpForm' => $this->signUpForm]);
    }

    public function actionIndex()
    {
        $this->renderForm();
    }

    public function actionCheckAvailability()
    {
        $value  = $_POST['value'];
        $column = $_POST['type'];
        $available  = (new User())->isInputAvailable([$column => $value]);
        echo json_encode(["available" => $available]);
    }

    public function actionConfirm()
    {
//        $userInput = [
//            'username'          => 'maks',
//            'first-name'        => '',
//            'last-name'         => 'gayduk',
//            'email'             => 'maksim.gayduk@gmail.com',
//            'password'          => '1234aaZZ',
//            'repeat-password'   => '1234aaZZ',
//        ];
//        if (isset($_POST['userInput'])) {
//            $userInput = json_decode($_POST['userInput'], true);
//        } else {
//            $userInput = $_POST;
//        }
        $userInput = $_POST;

        var_dump($userInput);

        $this->signUpForm->setSubmitted(true);
        $this->signUpForm->setFieldsValues($userInput);
        $this->validateForm();
        if ($this->signUpForm->isValid()) {
            $userInput = $this->signUpForm->getValues();
            (new User())->insertToDb($userInput);
            $this->sendActivationEmail($userInput['email']);
//            header('Location: http://camagru/');
        }
        else {
           $this->renderForm();
        }
//        $this->renderForm();
    }

    public function validateForm(): void
    {
        $this->signUpForm->validate(new InputChecker());
        if ($this->signUpForm->isValid()) {
            $this->signUpForm->checkAvailability((new User()));
        }
    }

    /**
     * @param string $email
     * @return bool
     */
    private function sendActivationEmail(string $email): bool
    {
        $subject = "Account activation";
        $activationCode = (new User())->getActivationCode($email);
        $link = $_SERVER['HTTP_HOST'] . '/sign-up/activate/' . $activationCode;
        $body = include(ROOT . DS . 'mails/activation.php');
        return (new Mailer())->sendEmail($email, $subject, $body);
    }

    public function actionActivate($activationCode)
    {
        $userModel = new User();

        $rowExists = $userModel->rowExists(['activation_code' => $activationCode]);
        if ($rowExists) {
            var_dump($userModel->activateAccount($activationCode));
            echo 'success';
        } else {
            echo 'Something going wrong';
        }
    }
}
