<?php
/** @var \app\widgets\inputForm\components\inputField\InputField $this */
/** @var \app\base\View $this->view  */
/** @var array $params */

use app\components\CaseTranslator;

$formWidgetName = $params['formWidgetName'] ?? CaseTranslator::toKebab($this->widgetName);
?>

<div class="<?= $formWidgetName . '__unit' ?>">
    <input id="<?= $formWidgetName . '__' . $this->name?>"
           class="<?= $formWidgetName . '__input ';
           echo $params['formSubmitted'] ? $this->isValid() ? 'valid-input' : 'invalid-input' : '' ?>"
           type="<?= $this->contentType ?>"
           name="<?= $this->name ?>"
           value="<?= $this->value ? $this->value : '' ?>"
           placeholder="<?= $this->placeholder ?>">
    <p class="<?= $formWidgetName . '__validation '; echo $this->isValid() ? '' : "invalid-message" ?>">
        <?= $this->isValid() ? '' : $this->message ?>
    </p>
</div>
