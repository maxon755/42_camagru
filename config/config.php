<?php

$config = [

    /*
     *  mode = debug - display debug information
     */
    'mode' => 'dev',

    'components' => [
        'header' => [
            'path' =>  ROOT . '/template/header/header.php',
            'stylePath' => '/template/header/header.css'
        ]
    ]
];

return $config;
