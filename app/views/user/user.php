<?php echo 'page of ' . $parameters['username'] ?>



<?php

    include ('toolbar.php');
    include ('camera.php');


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
