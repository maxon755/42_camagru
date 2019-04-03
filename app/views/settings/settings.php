<?php
/** @var app\base\View $this */
/** @var app\models\Settings $form */
/** @var array $parameters */

$this->registerJsFile('/widgets/input-form/input-validator.js', true);

?>

<nav>
    <div class="nav nav-tabs">
        <a class="nav-item nav-link active" href="#general" data-pane="general">General</a>
        <a class="nav-item nav-link" href="#password" data-pane="password">Password</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="general">
        <div class="container" align="center">
            <div class="row justify-content-center">
                <div class="col-sm-8 col-md-6 nopadding">
                    <?php $parameters['settingsForm']->render() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="password">
        <div class="container" align="center">
            <div class="row justify-content-center">
                <div class="col-sm-8 col-md-6 nopadding">
                    <?php $parameters['passwordForm']->render() ?>
                </div>
            </div>
        </div>
    </div>
</div>
