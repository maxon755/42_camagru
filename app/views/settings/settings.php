<?php
/** @var app\base\View $this */
/** @var app\models\Settings $form */
/** @var array $parameters */

$this->registerJsFile('/widgets/input-form/input-validator.js', true);

?>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-general-tab" data-toggle="tab"
           href="#nav-general" data-pane="nav-general">General</a>
        <a class="nav-item nav-link" id="nav-password-tab" data-toggle="tab" href="#nav-password"
           data-pane="nav-password">Password</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="container" align="center">
            <div class="row justify-content-center">
                <div class="col-sm-8 col-md-6 nopadding">
                    <?php $parameters['settingsForm']->render() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab">
        <div class="container" align="center">
            <div class="row justify-content-center">
                <div class="col-sm-8 col-md-6 nopadding">
                    <?php $parameters['passwordForm']->render() ?>
                </div>
            </div>
        </div>
    </div>
</div>
