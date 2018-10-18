
<form class="sign_up" action="empty/index" method="POST">

    <h2 class="sign_up__header">Sign Up</h2>

    <hr class="sign_up__line">

    <div class="sign_up__container">

        <?php foreach($this->inputFields as $field): ?>
            <div class="<?php echo $this->formName . '__unit' ?>">
                <input id="<?php echo $this->formName . '__' . $field->getName()?>"
                       class="<?php echo $this->formName . '__input' ?>"
                       type="text" name="<?php echo $field->getName()?>"
                       placeholder="<?php echo $field->getName() . ' *'?>" required>
                <p class="
                    <?php
                        echo $field->getValidity()
                        ? "sign_up__validation"
                        : "sign_up__validation invalid-message";
                ?>
                ">
                    <?php
                    if (!$field->getValidity())
                    {
                        echo $field->getMessage();
                    }?>
                </p>
            </div>
        <?php endforeach; ?>
        <input  id="sign_up__submit"
                class="sign_up__submit"
                type="submit" value="Submit">
    </div>
</form>
