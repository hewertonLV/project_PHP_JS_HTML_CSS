<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

require_once '../app/controllers/UserController.php';

function handleRequest($uri) {
    $uri = trim($uri, '/');

    $routes = [
        '' => 'dashboard',
        'login' => 'login',    
        'register' => 'register', 
        'profile' => 'profile', 
        'logout' => 'logout'   
    ];

    if (array_key_exists($uri, $routes)) {
        $controller = new UserController();
        $action = $routes[$uri];
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            echo "Ação $action não encontrada!";
        }
    } else {
        echo "Página não encontrada!";
    }
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
handleRequest($uri);
