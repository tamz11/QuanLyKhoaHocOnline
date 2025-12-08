<?php
// index.php

session_start();

// Autoload đơn giản (có thể cải tiến sau)
spl_autoload_register(function ($class) {
    $paths = ['controllers', 'models', 'config'];
    foreach ($paths as $path) {
        $file = __DIR__ . "/$path/$class.php";
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Lấy controller & action từ URL
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'HomeController';
$actionName      = isset($_GET['action']) ? $_GET['action'] : 'index';

// Tạo biến user hiện tại (nếu đã login)
$currentUser = isset($_SESSION['user']) ? $_SESSION['user'] : null;

// Gọi controller
if (class_exists($controllerName)) {
    $controller = new $controllerName($currentUser);
    if (method_exists($controller, $actionName)) {
        $controller->$actionName();
    } else {
        die("Action $actionName không tồn tại!");
    }
} else {
    die("Controller $controllerName không tồn tại!");
}
