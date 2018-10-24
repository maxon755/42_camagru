<?php

$config = [
    'appName' => 'Camagru',

    /*
     *  mode = debug - display debug information
     */
    'mode' => 'dev',

    'db' => include 'database.php',

    'viewComponents' => [
        'header' => [
            'path' =>  ROOT . '/template/header/header.php',
            'stylePath' => '/template/header/header.css'
        ]
    ]
];

return $config;
