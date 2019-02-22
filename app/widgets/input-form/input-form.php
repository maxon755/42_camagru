<?php
    /** @var \app\widgets\inputForm\InputForm $this */
    /** @var \app\base\View $this->view  */

    use app\components\CaseTranslator;

    $widgetName = CaseTranslator::toKebab($this->widgetName);
    $this->view->registerCssFile('widgets/input-form/input-form.css', true);
?>

<div class="<?= CaseTranslator::toKebab($this->getShortClassName()) ?>">
    <form class="<?= $widgetName ?>" action="<?= $this->action ?>" method="<?= $this->method ?>">

        <h2 class="<?= $widgetName . '__header' ?>"><?= $this->tittle ?></h2>

        <hr class="<?= $widgetName . '__line' ?>">

        <div class="<?= $widgetName . '__container' ?>">

            <?php foreach($this->inputFields as $field): ?>
                <div class="<?= $widgetName . '__unit' ?>">
                    <input id="<?= $widgetName . '__' . $field->getName() //id? ?>"
                           class="<?= $widgetName . '__input ';
                           echo $this->submitted ? $field->isValid() ? 'valid-input' : 'invalid-input' : '' ?>"
                           type="<?= $field->getContentType() ?>"
                           name="<?= $field->getName() ?>"
                           value="<?= $field->getValue() ? $field->getValue() : '' ?>"
                           placeholder="<?= $field->getPlaceholder() ?>">
                    <p class="<?= $widgetName . '__validation '; echo $field->isValid() ? '' : "invalid-message" ?>">
                        <?= $field->isValid() ? '' : $field->getMessage() ?>
                    </p>
                </div>
            <?php endforeach ?>
            <input  id="<?= $widgetName . '__submit' ?>"
                    class="<?= $widgetName . '__submit' ?>"
                    type="submit" value="Submit">
        </div>
    </form>
</div>

