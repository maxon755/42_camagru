<?php

spl_autoload_register(function ($class) {
    $pathParts = explode('\\', $class);
    $classFolder = $pathParts[1];
    $className = $pathParts[2] . '.php';
    $path = ROOT . DS . $classFolder . DS . $className;
    if (file_exists($path))
    {
        require_once $path;
    }
});
