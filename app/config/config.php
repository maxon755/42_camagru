<?php

$config = [
    'appName' => 'Camagru',

    /*
     *  mode = debug - display debug information
     */
    'mode'              => 'dev',
    'db'                => include 'database.php',
    'storage'           => 'storage',
    'imagesFolder'      => 'images',
];

return $config;
