<?php
/** @var app\base\View $this */
/** @var app\models\Settings $form */
/** @var array $parameters */

$this->registerJsFile('/widgets/input-form/input-validator.js', true);

?>

<div class="container" align="center">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-6 nopadding">
            <?php $parameters['settingsForm']->render() ?>
        </div>
    </div>
</div>
