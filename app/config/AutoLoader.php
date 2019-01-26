<?php

spl_autoload_register(function ($class) {
    $pathParts = array_slice(explode('\\', $class), 1);
    $path = ROOT;
    foreach ($pathParts as $pathPart) {
        $path .= DS . $pathPart;
    }
    $class = $path . '.php';
    if (file_exists($class)) {
        require_once $class;
    }
});
