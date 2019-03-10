<?php
/** @var \app\widgets\inputForm\components\inputField\InputField $this */
/** @var \app\base\View $this->view  */
/** @var array $params */

use app\components\CaseTranslator;

$widgetName = CaseTranslator::toKebab($this->widgetName);
?>

<div class="<?= $widgetName . '__unit' ?>">
    <input id="<?= $widgetName . '__' . $this->getName()?>"
           class="<?= $widgetName . '__input ';
           echo $params['formSubmitted'] ? $this->isValid() ? 'valid-input' : 'invalid-input' : '' ?>"
           type="<?= $this->getContentType() ?>"
           name="<?= $this->getName() ?>"
           value="<?= $this->value ? $this->value : '' ?>"
           placeholder="<?= $this->getPlaceholder() ?>">
    <p class="<?= $widgetName . '__validation '; echo $this->isValid() ? '' : "invalid-message" ?>">
        <?= $this->isValid() ? '' : $this->getMessage() ?>
    </p>
</div>
