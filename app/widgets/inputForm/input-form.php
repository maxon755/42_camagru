
<form class="<?php echo $this->formName ?>" action="<?php echo $this->action?>" method="<?php echo $this->method?>">

    <h2 class="<?php echo $this->formName . '__header' ?>"><?php echo $this->tittle?></h2>

    <hr class="<?php echo $this->formName . '__line' ?>">

    <div class="<?php echo $this->formName . '__container' ?>">

        <?php foreach($this->inputFields as $field): ?>
            <div class="<?php echo $this->formName . '__unit' ?>">
                <input id="<?php echo $this->formName . '__' . $field->getName()?>"
                       class="<?php echo $this->formName . '__input ';
                                    echo $this->submitted ? $field->isValid() ? 'valid-input' : 'invalid-input' : '' ?>"
                       type="<?php echo $field->getContentType()?>"
                       name="<?php echo $field->getName()?>"
                       value="<?php echo $field->getValue() ? $field->getValue() : ''?>"
                       placeholder="<?php echo $field->getPlaceholder(); ?>">
                <p class="<?php echo $this->formName . '__validation '; echo $field->isValid() ? '' : "invalid-message"; ?>">
                    <?php echo $field->isValid() ? '' : $field->getMessage();?>
                </p>
            </div>
        <?php endforeach; ?>
        <input  id="<?php echo $this->formName . '__submit' ?>"
                class="<?php echo $this->formName . '__submit' ?>"
                type="submit" value="Submit">
    </div>
</form>
