<?php


namespace app\controllers;


use app\base\Controller;
use app\components\Mailer;
use app\models\Client;
use app\models\PasswordSettings;
use app\models\PasswordToken;
use app\models\RestorePasswordForm;

class RestorePasswordController extends Controller
{
    /** @var RestorePasswordForm  */
    private $requestPasswordForm;

    /** @var PasswordSettings  */
    private $restorePasswordForm;

    private const REQUEST_VIEW_NAME = 'restore-password-request';

    public function __construct()
    {
        $this->requestPasswordForm = new RestorePasswordForm();
        $this->restorePasswordForm = new PasswordSettings('Restore Password');

    }

    public function actionIndex()
    {
        $this->renderForm();
    }

    private function renderForm()
    {
        $this->render(self::REQUEST_VIEW_NAME, true, [
            'form' => $this->requestPasswordForm
        ]);
    }

    public function actionConfirm()
    {
        $userInput = $_POST;

        if ($this->requestPasswordForm->checkUsername($userInput)) {
            $clientModel = new Client();

            $username = $userInput['username'];

            $data = $clientModel->getValues(['user_id', 'email'], [
                'username' => $username,
            ])[0];

            $this->sendRestorationMail($data['user_id'],$username, $data['email']);
            $this->requestPasswordForm->setResult(
                'Check your email for further instructions', 'success');
        }

        $this->renderForm();
    }

    /**
     * @param string $email
     * @return string
     */
    private function prepareRestorationToken(int $userId, string $email): string
    {
        $passwordTokenModel = new PasswordToken();
        $token = uniqid('', true);
        $passwordTokenModel->insertToken($userId, $token);

        return $token;
    }

    /**
     * @param string $username
     * @return bool
     */
    private function sendRestorationMail(int $userId, string $username, string $email): bool
    {
        $token = $this->prepareRestorationToken($userId, $email);
        $link = $_SERVER['HTTP_HOST'] . '/restore-password/set-new/' . $userId . '/' . $token;
        $body = include(ROOT . DS . 'mails/restoration.php');
        return (new Mailer())->sendEmail(
            $email,
            'Password Restoration',
            $body
        );
    }

    public function actionSetNew(int $userId, string $token)
    {
        $action = '/restore-password/save/' . $userId . '/' . $token;
        $this->restorePasswordForm->setAction($action);

        $this->render(self::REQUEST_VIEW_NAME, true, [
            'form' => $this->restorePasswordForm,
        ]);
    }

    public function actionSave(int $userId, string $token)
    {
        $userInput = $_POST;
        $passwordTokenModel = new PasswordToken();

        $tokenIsValid = $passwordTokenModel->rowExists([
            'user_id' => $userId,
            'token'   => $token,
        ]);

        if (!$tokenIsValid) {
            $this->restorePasswordForm->setResult('Wrong link', 'danger');
        } else {
            $this->restorePasswordForm->save($userInput);
        }

        $this->render(self::REQUEST_VIEW_NAME, true, [
            'form' => $this->restorePasswordForm,
        ]);
    }
}
