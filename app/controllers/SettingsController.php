<?php


namespace app\controllers;


use app\base\Controller;
use app\models\Client;
use app\models\Settings;

class SettingsController extends Controller
{
    private const VIEW_NAME = 'settings';

    /** @var Settings  */
    private $settingsForm;

    /** @var Client  */
    private $userModel;

    public function __construct()
    {
        $this->userModel = new Client();
        $this->settingsForm = new Settings();

        $userId = self::$auth->getUserId();
        $userData = $this->userModel->getUserData($userId);
        $this->settingsForm->setFieldsValues($userData);
    }

    public function renderForm()
    {
        $this->render($this::VIEW_NAME, true, ['settingsForm' => $this->settingsForm]);
    }

    public function actionIndex()
    {
        $this->renderForm();
    }

    public function actionSave()
    {
        $userInput = $_POST;

        if ($this->settingsForm->save($userInput)) {
            $userInput = $this->settingsForm->getValues();
            self::$auth->login($userInput['username']);
            // TODO: notify about update result;
            header('Location: /settings');
        }

        $this->renderForm();
    }
}