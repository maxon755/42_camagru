<?php
/** @var \app\widgets\inputForm\components\textArea\TextArea $this */
/** @var \app\base\View $this->view  */
/** @var array $params */

use app\components\CaseTranslator;

$widgetName = CaseTranslator::toKebab($this->widgetName);
$formWidgetName = $params['formWidgetName'] ?? CaseTranslator::toKebab($this->widgetName);
?>

<div class="<?= $formWidgetName . '__unit' ?>">
    <textarea id="<?= $formWidgetName . '__' . $this->name?>"
        class="<?= $formWidgetName . "__$widgetName" ?>"
        name="<?= $this->name ?>"
        placeholder="<?= $this->placeholder ?>"
        rows="<?= $this->rows ?>"
    >
    </textarea>
</div>
