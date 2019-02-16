
<form class="<?= $this->formName ?>" action="<?= $this->action ?>" method="<?= $this->method ?>">

    <h2 class="<?= $this->formName . '__header' ?>"><?= $this->tittle ?></h2>

    <hr class="<?= $this->formName . '__line' ?>">

    <div class="<?= $this->formName . '__container' ?>">

        <?php foreach($this->inputFields as $field): ?>
            <div class="<?= $this->formName . '__unit' ?>">
                <input id="<?= $this->formName . '__' . $field->getName() ?>"
                       class="<?= $this->formName . '__input ';
                                    echo $this->submitted ? $field->isValid() ? 'valid-input' : 'invalid-input' : '' ?>"
                       type="<?= $field->getContentType() ?>"
                       name="<?= $field->getName() ?>"
                       value="<?= $field->getValue() ? $field->getValue() : '' ?>"
                       placeholder="<?= $field->getPlaceholder() ?>">
                <p class="<?= $this->formName . '__validation '; echo $field->isValid() ? '' : "invalid-message" ?>">
                    <?= $field->isValid() ? '' : $field->getMessage() ?>
                </p>
            </div>
        <?php endforeach ?>
        <input  id="<?= $this->formName . '__submit' ?>"
                class="<?= $this->formName . '__submit' ?>"
                type="submit" value="Submit">
    </div>
</form>
