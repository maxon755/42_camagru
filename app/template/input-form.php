
<form class="<?php echo $this->formName ?>" action="<?php echo $this->action ?>" method="POST">

    <h2 class="<?php echo $this->formName . '__header' ?>"><?php echo $this->formName?></h2>

    <hr class="<?php echo $this->formName . '__line' ?>">

    <div class="<?php echo $this->formName . '__container' ?>">

        <?php foreach($this->inputFields as $field): ?>
            <div class="<?php echo $this->formName . '__unit' ?>">
                <input id="<?php echo $this->formName . '__' . $field->getName()?>"
                       class="<?php echo $this->formName . '__input' ?>"
                       type="<?php echo $field->getContentType()?>"
                       name="<?php echo $field->getName()?>"
                       placeholder="<?php
                                echo $field->isRequired() ? $field->getName() . ' *' : $field->getName();
                            ?>" required>
                <p class="
                    <?php
                        echo $field->isValid()
                        ? "sign_up__validation"
                        : "sign_up__validation invalid-message";
                    ?>
                ">
                    <?php echo $field->isValid() ? '' : $field->getMessage(); ?>
                </p>
            </div>
        <?php endforeach; ?>
        <input  id="<?php echo $this->formName . '__submit' ?>"
                class="<?php echo $this->formName . '__submit' ?>"
                type="submit" value="Submit">
    </div>
</form>
