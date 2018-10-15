<?php

$config = [
    'appName' => 'Camagru',

    /*
     *  mode = debug - display debug information
     */
    'mode' => 'dev',

    'db' => [
        'host' 		=> 'localhost',
        'dbname' 	=> 'camagru',
        'user' 		=> 'root',
        'password' 	=> 'root42',
        'charset'   => 'utf8'
    ],

    'components' => [
        'header' => [
            'path' =>  ROOT . '/template/header/header.php',
            'stylePath' => '/template/header/header.css'
        ]
    ]
];

return $config;
