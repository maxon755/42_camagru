<?php
/** @var \app\widgets\inputForm\InputForm $this */
/** @var \app\base\View $this->view  */

use app\components\CaseTranslator;

$widgetName = CaseTranslator::toKebab($this->widgetName);
//$this->view->registerCssFile('/widgets/input-form/input-form.css', true);
?>

<div class="<?= $this->name ?>">
    <form class="<?= $widgetName ?>" action="<?= $this->action ?>" method="<?= $this->method ?>">

        <?php if ($this->header): ?>
            <h2 class="<?= $widgetName . '__header' ?>"><?= $this->tittle ?></h2>
            <hr class="<?= $widgetName . '__line' ?>">
        <?php endif; ?>


        <div class="<?= $widgetName . '__container' ?>">

            <?php $i = 1 ?>
            <?php foreach($this->inputs as $field): ?>
                <div class="<?=  $widgetName . '__unit-' . $i++ ?>">
                    <?= $field->render([
                        'formWidgetName'    => $widgetName,
                        'formSubmitted'     => $this->submitted
                    ]) ?>
                </div>
            <?php endforeach ?>
            <input class="<?= $widgetName . '__submit' ?>"
                   type="submit" value="Submit">
        </div>
    </form>
</div>

<?php

$inputs = [];
foreach ($this->inputs as $name => $field) {
    $inputs[$name] = [
        'id'     => $field->getId(),
        'unique' => $field->isUnique(),
    ];
}
$inputs = json_encode($inputs);

    $this->view->registerJsScript(<<<JS
var inputForm = {
        fields : $inputs
};
JS
);
