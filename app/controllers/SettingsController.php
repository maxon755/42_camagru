<?php


namespace app\controllers;


use app\base\Controller;
use app\models\Client;
use app\models\Settings;

class SettingsController extends Controller
{
    private const VIEW_NAME = 'settings';

    private $settingsForm;

    private $userModel;

    public function __construct()
    {
        $this->userModel = new Client();
        $this->settingsForm = new Settings();


        $userId = self::$auth->getUserId();
        $userData = $this->userModel->getUserData($userId);
        $this->settingsForm->setFieldsValues($userData);
    }

    public function actionIndex() {
        echo self::VIEW_NAME;
        $this->render($this::VIEW_NAME, true, ['settingsForm' => $this->settingsForm]);
    }
}