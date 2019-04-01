<?php
/** @var \app\widgets\inputForm\components\inputField\InputField $this */
/** @var \app\base\View $this->view  */
/** @var array $params */

use app\components\CaseTranslator;

$widgetName = CaseTranslator::toKebab($this->widgetName);
$formWidgetName = $params['formWidgetName'] ?? $widgetName;
$this->id = $this->id ?? $formWidgetName . '__' . $this->name;
?>

<input id="<?= $this->id ?>"
       class="<?= $formWidgetName . "__$widgetName ";
       echo $params['formSubmitted'] ? $this->isValid() ? 'valid-input' : 'invalid-input' : '' ?>"
       type="<?= $this->type ?>"
       name="<?= $this->name ?>"
       value="<?= $this->value ? $this->value : '' ?>"
       placeholder="<?= $this->placeholder ?>">
<?php if (!empty($this->checks)): ?>
    <p class="<?= $formWidgetName . '__validation ' . ($this->isValid() ? '' : "invalid-message") ?>">
        <?= $this->isValid() ? '' : $this->message ?>
    </p>
<?php endif; ?>
