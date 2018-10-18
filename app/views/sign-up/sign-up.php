<a href="login">return</a>


    <?php $parameters['signUpForm']->render(); ?>
<!--<form class="sign_up" action="empty/index" method="POST">-->
<!---->
<!--    <h2 class="sign_up__header">Sign Up</h2>-->
<!---->
<!--    <hr class="sign_up__line">-->
<!---->
<!--    <div class="sign_up__container">-->
<!---->
<!--        <div class="sign_up__unit">-->
<!--            <input id="sign_up__username"-->
<!--                   class="sign_up__input"-->
<!--                   type="text" name="username"-->
<!--                   placeholder="username *" required>-->
<!--            <p class="-->
<!--                    --><?php
//                        echo $parameters['username']->getValidity()
//                        ? "sign_up__validation"
//                        : "sign_up__validation invalid-message";
//                    ?>
<!--                ">-->
<!--                --><?php
//                    if (!$parameters['username']->getValidity())
//                        {
//                            echo $parameters['username']->getMessage();
//                        }?>
<!--            </p>-->
<!--        </div>-->
<!---->
<!--        <div class="sign_up__unit">-->
<!--            <input id="sign_up__first-name"-->
<!--                   class="sign_up__input"-->
<!--                   type="text" name="first-name"-->
<!--                   placeholder="First Name">-->
<!--            <p class="sign_up__validation invalid">-->
<!---->
<!--            </p>-->
<!--        </div>-->
<!---->
<!--        <div class="sign_up__unit">-->
<!--            <input id="sign_up__last-name"-->
<!--                   class="sign_up__input"-->
<!--                   type="text" name="last-name"-->
<!--                   placeholder="Last Name">-->
<!--            <p class="sign_up__validation valid">-->
<!---->
<!--            </p>-->
<!--        </div>-->
<!---->
<!--        <div class="sign_up__unit">-->
<!--            <input id="sign_up__email"-->
<!--                   class="sign_up__input"-->
<!--                   type="email" name="email"-->
<!--                   placeholder="Email *" required>-->
<!--            <p class="sign_up__validation valid">-->
<!---->
<!--            </p>-->
<!--        </div>-->
<!---->
<!--        <div class="sign_up__unit">-->
<!--            <input id="sign_up__password"-->
<!--                   class="sign_up__input"-->
<!--                   type="password" name="password"-->
<!--                   placeholder="Password *" required>-->
<!--            <p class="sign_up__validation valid">-->
<!---->
<!--            </p>-->
<!--        </div>-->
<!---->
<!---->
<!--        <div class="sign_up__unit">-->
<!--            <input id="sign_up__repeat-password"-->
<!--                   class="sign_up__input"-->
<!--                   type="password" name="repeat-passwordd"-->
<!--                   placeholder="Repeat Password *" required>-->
<!--            <p class="sign_up__validation valid">-->
<!---->
<!--            </p>-->
<!--        </div>-->
<!---->
<!--        <input  id="sign_up__submit"-->
<!--                class="sign_up__submit"-->
<!--                type="submit" value="Submit">-->
<!--    </div>-->
<!---->
<!---->
<!---->
<!--</form>-->
