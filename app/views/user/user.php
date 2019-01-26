<?php echo 'page of ' . $parameters['username'] ?>



<?php

    include ('camera.php');


    $this->registerJsFile('flexible/flexible.js');
    $this->registerCssFile('flexible/flexible.css');

    if (self::$auth->selfPage($parameters['username']))
    {
        echo 'self page';
    }
    else
    {
        echo 'Other page';
    };
