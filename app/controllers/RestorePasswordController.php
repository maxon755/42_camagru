<?php


namespace app\controllers;


use app\base\Controller;
use app\models\RestorePasswordForm;

class RestorePasswordController extends Controller
{
    /** @var RestorePasswordForm  */
    private $restorePasswordForm;

    private const VIEW_NAME = 'restore-password';

    public function __construct()
    {
        $this->restorePasswordForm = new RestorePasswordForm();
    }

    public function actionIndex()
    {
        $this->renderForm();
    }

    private function renderForm()
    {
        $this->render(self::VIEW_NAME, true, [
            'form' => $this->restorePasswordForm
        ]);
    }
}
