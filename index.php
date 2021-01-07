<?php

// Main autoloader, loads models, controllers and classes on demand.
spl_autoload_register(function ($class_name) {
    if (file_exists('./classes/' . $class_name . '.php')) {
        require_once './classes/' . $class_name . '.php';
    } else if (file_exists('./Controllers/' . $class_name . '.php')) {
        require_once './Controllers/' . $class_name . '.php';
    } else if (file_exists('./models/' . $class_name . '.php')) {
        require_once './models/' . $class_name . '.php';
    }
});

// Running routes.php defines all routes, which are then
// handeled by Route.php dynamically using .htaccess rewrites
require_once "Routes.php";
