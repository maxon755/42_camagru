<?php
/** @var array $parameters */
?>

<div class="container" align="center">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-6 nopadding">
            <?php $parameters['loginForm']->render() ?>
            <div class="tool-box">
                <a href="/sign-up" class="btn btn-success btn-block">Create an account</a>
                <a href="/restore-password" class="btn btn-dark btn-block">Forgot the password?</a>
            </div>
        </div>
    </div>
</div>
