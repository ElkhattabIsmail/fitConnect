<?php

require_once __DIR__ . '/../config/Database.php';

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../app/' . str_replace(['App\\', '\\'], ['', '/'], $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Define base URL for links
$baseUrl = $_SERVER['SCRIPT_NAME'];

$routes = [
    'adherents' => 'AdherentController',
    'abonnements' => 'AbonnementController',
    'dashboard' => 'SeanceController',
];

$route = $_GET['route'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

$controllerClass = 'App\\Controllers\\' . ($routes[$route] ?? 'SeanceController');
$controller = new $controllerClass();

if ($id !== null && method_exists($controller, $action)) {
    $controller->$action((int) $id);
} elseif (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
