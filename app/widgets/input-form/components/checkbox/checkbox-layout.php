<?php

use app\components\CaseTranslator;

$widgetName = CaseTranslator::toKebab($this->widgetName);
$formWidgetName = $params['formWidgetName'] ?? $widgetName;
$this->id = $this->id ?? $formWidgetName . '__' . $this->name;
?>

<input id="<?= $this->id . '-hidden' ?>"
       class="<?= $formWidgetName . "__" . $widgetName ?>"
    <?= $this->value ? 'checked' : '' ?>
       type="hidden"
       name="<?= $this->name ?>"
       value="<?= false ?>">


<div class="<?= $widgetName . '-wrapper' ?> form-check">
    <input id="<?= $this->id ?>"
           class="<?= $formWidgetName . "__" . $widgetName ?> form-check-input"
        <?= $this->value ? 'checked' : '' ?>
           type="checkbox"
           name="<?= $this->name ?>"
           value="<?= true ?>">
    <label for="<?= $this->id ?>" class="form-check-label">
        <?= $this->label ?? $this->name ?>
    </label>
</div>
