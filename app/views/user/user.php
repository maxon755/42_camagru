<?php echo 'page of ' . $parameters['username'] ?>

<div id="user__root">
    <div id="user__photo">
        <?php
            include_once('camera.php');
            include_once('toolbar.php');
        ?>
    </div>
    <div id="user__past-photos">

    </div>
</div>



<?php
    $this->registerJsFile('flexible/flexible.js');
    $this->registerCssFile('flexible/flexible.css');
    $this->registerCssFile('user');


if (self::$auth->selfPage($parameters['username']))
    {
        echo 'self page';
    }
    else
    {
        echo 'Other page';
    };
