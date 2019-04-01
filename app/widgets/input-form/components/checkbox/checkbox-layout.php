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

<input id="<?= $this->id ?>"
    class="<?= $formWidgetName . "__" . $widgetName ?>"
    <?= $this->value ? 'checked' : '' ?>
    type="checkbox"
    name="<?= $this->name ?>"
    value="<?= true ?>">
<label for="<?= $this->id ?>">
    <?= $this->label ?? $this->name ?>
</label>
