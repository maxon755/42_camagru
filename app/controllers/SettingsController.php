<?php


namespace app\controllers;


use app\base\Controller;
use app\components\CaseTranslator;
use app\components\Header;
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
            $username = $form->getValues()['username'] ?? null;
            if ($username) {
                self::$auth->login($userInput['username']);
            }
            // TODO: notify about update result;

            $url = $this->getUrl($userInput['formName']);
            Header::location($url);
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

    /**
     * @param string $formName
     * @return string
     */
    private function getUrl(string $formName): string
    {
        return '/settings#' . explode('-', $formName)[0];
    }
}
