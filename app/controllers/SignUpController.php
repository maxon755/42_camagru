<?php

namespace app\controllers;

use app\base\Controller;
use app\components\LogStateHandler;
use app\components\Mailer;
use app\models\SignUpForm;
use app\models\Client;

class SignUpController extends Controller
{
    private $signUpForm;

    const VIEW_NAME = 'sign-up';

    use LogStateHandler;

    public function __construct()
    {
        $this->signUpForm = new SignUpForm();
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
        $available  = (new Client())->isInputAvailable([$column => $value]);
        echo json_encode(["available" => $available]);
    }

    public function actionConfirm()
    {
        $userInput = $_POST;

        $userInput = [
            'username'          => 'maks',
            'first-name'        => '',
            'last-name'         => 'gayduk',
            'email'             => 'maksim.gayduk@gmail.com',
            'password'          => '1234aaZZ',
            'repeat-password'   => '1234aaZZ',
        ];

        $result = $this->signUpForm->confirm($userInput);

        if ($result) {
            $this->sendActivationEmail($userInput['email']);
            header('Location: /');
        }
        else {
           $this->renderForm();
        }
    }

    /**
     * @param string $email
     * @return bool
     */
    private function sendActivationEmail(string $email): bool
    {
        $subject = "Account activation";
        $activationCode = (new Client())->getActivationCode($email);
        $link = $_SERVER['HTTP_HOST'] . '/sign-up/activate/' . $activationCode;
        $body = include(ROOT . DS . 'mails/activation.php');

        return (new Mailer())->sendEmail($email, $subject, $body);
    }

    /**
     * @param string $activationCode
     */
    public function actionActivate(string $activationCode): void
    {
        $clientModel = new Client();

        $clientData = $clientModel->getRowWhere(['activation_code' => $activationCode]);

        if (!empty($clientData)
            && $clientModel->activateAccount($activationCode)
            && self::$auth->login($this->signUpForm->getValue('username'))) {
            echo 'success';
        } else {
            echo 'Something going wrong';
        }
    }
}
