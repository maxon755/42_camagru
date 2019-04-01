<?php

use app\components\CaseTranslator;

$widgetName = CaseTranslator::toKebab($this->widgetName);
$formWidgetName = $params['formWidgetName'] ?? $widgetName;
?>

<div class="<?= $formWidgetName . '__unit' ?>">
    <input id="<?= ($this->id ?? $this->name) . '-hidden' ?>"
           class="<?= $formWidgetName . "__" . $widgetName ?>"
        <?= $this->value ? 'checked' : '' ?>
           type="hidden"
           name="<?= $this->name ?>"
           value="<?= false ?>">

    <input id="<?= $this->id ?? $this->name ?>"
        class="<?= $formWidgetName . "__" . $widgetName ?>"
        <?= $this->value ? 'checked' : '' ?>
        type="checkbox"
        name="<?= $this->name ?>"
        value="<?= true ?>">
    <label for="<?= $this->id ?? $this->name ?>">
        <?= $this->label ?? $this->name ?>
    </label>
</div>
