<?php


namespace app\controllers;


use app\base\Controller;
use app\components\CaseTranslator;
use app\models\Client;
use app\models\GeneralSettings;
use app\models\PasswordSettings;
use app\models\Settings;

class SettingsController extends Controller
{
    private const VIEW_NAME = 'settings';

    /** @var Settings  */
    private $generalSettingsForm;

    /** @var PasswordSettings */
    private $passwordSettingsForm;

    /** @var Client  */
    private $userModel;

    public function __construct()
    {
        $this->userModel = new Client();
        $this->generalSettingsForm = new GeneralSettings();
        $this->passwordSettingsForm = new PasswordSettings();

        $userId = self::$auth->getUserId();
        $userData = $this->userModel->getUserData($userId);
        $this->generalSettingsForm->setFieldsValues($userData);
    }

    public function renderForm()
    {
        $this->render($this::VIEW_NAME, true, [
            'settingsForm' => $this->generalSettingsForm,
            'passwordForm' => $this->passwordSettingsForm,
        ]);
    }

    public function actionIndex()
    {
        $this->renderForm();
    }

    public function actionSave()
    {
        $userInput = $_POST;

        $form = $this->getForm($userInput['formName']);

        if ($form->save($userInput)) {
            $userInput = $this->generalSettingsForm->getValues();
            self::$auth->login($userInput['username']);
            // TODO: notify about update result;
        }

        $this->renderForm();
    }

    /**
     * @param string $formName
     * @return Settings|null
     */
    private function getForm(string $formName): ?Settings
    {
        $formName = CaseTranslator::toCamel($formName) . 'Form';

        return $this->{$formName};
    }
}
