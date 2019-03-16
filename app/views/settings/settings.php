<?php
/** @var app\base\View $this */
/** @var app\models\Settings $form */
/** @var array $parameters */

$this->registerJsFile('/widgets/input-form/input-validator.js', true);

$form = $parameters['settingsForm'];

$form->render();
?>