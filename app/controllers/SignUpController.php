<?php

namespace app\controllers;

use app\base\Controller;
use app\components\Header;
use app\components\Mailer;
use app\models\SignUpForm;
use app\models\Client;

class SignUpController extends Controller
{
    /** @var SignUpForm  */
    private $signUpForm;

    const VIEW_NAME = 'sign-up';

    public function __construct()
    {
        $this->signUpForm = new SignUpForm();
    }

    private function renderForm(): void
    {
        $this->render(self::VIEW_NAME, true, ['signUpForm' => $this->signUpForm]);
    }

    public function actionIndex()
    {
        $this->renderForm();
    }

    public function actionCheckAvailability(): void
    {
        $value  = $_POST['value'];
        $column = $_POST['type'];
        $available  = (new Client())->isInputAvailable([$column => $value]);
        echo $this->jsonResponse(true, [
            "available" => $available
        ]);
    }

    public function actionConfirm(): void
    {
        $userInput = $_POST;

        $result = $this->signUpForm->confirm($userInput);

        if ($result && $this->sendActivationEmail($userInput['email'])) {
            $this->signUpForm->setResult('The activation link was sent to your email', 'success');
        }

        $this->renderForm();
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
            && self::$auth->login($clientData['username'])) {
            Header::location('/');
        }
    }
}
