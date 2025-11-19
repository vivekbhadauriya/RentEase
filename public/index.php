<?php
// public/index.php

require_once __DIR__ . '/../src/config.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Helpers.php';

$config = include __DIR__ . '/../src/config.php';
Database::getInstance($config);
$pdo = Database::getInstance()->pdo();

// Autoload controllers and models
spl_autoload_register(function($class){
    $paths = [__DIR__ . '/../src/controllers/', __DIR__ . '/../src/models/'];
    foreach ($paths as $p) {
        if (file_exists($p.$class.'.php')) include $p.$class.'.php';
    }
});

// Basic session start for flash messages
if (!session_id()) session_start();

$route = $_GET['route'] ?? 'dashboard';
$method = $_SERVER['REQUEST_METHOD'];

switch($route) {
    case 'dashboard':
        require __DIR__ . '/../src/views/dashboard.php';
        break;

    case 'properties':
        $controller = new PropertyController($pdo);
        if ($method === 'POST' && isset($_POST['_action']) && $_POST['_action'] === 'create') $controller->store();
        elseif ($method === 'POST' && isset($_POST['_action']) && $_POST['_action'] === 'update') $controller->update($_POST['id']);
        elseif (isset($_GET['action']) && $_GET['action'] === 'create') $controller->create();
        elseif (isset($_GET['action']) && $_GET['action'] === 'edit') $controller->edit((int)$_GET['id']);
        elseif (isset($_GET['action']) && $_GET['action'] === 'delete') $controller->destroy((int)$_GET['id']);
        else $controller->index();
        break;

    case 'tenants':
        $controller = new TenantController($pdo);
        if ($method === 'POST' && isset($_POST['_action']) && $_POST['_action'] === 'create') $controller->store();
        elseif ($method === 'POST' && isset($_POST['_action']) && $_POST['_action'] === 'update') $controller->update($_POST['id']);
        elseif (isset($_GET['action']) && $_GET['action'] === 'create') $controller->create();
        elseif (isset($_GET['action']) && $_GET['action'] === 'edit') $controller->edit((int)$_GET['id']);
        elseif (isset($_GET['action']) && $_GET['action'] === 'delete') $controller->destroy((int)$_GET['id']);
        else $controller->index();
        break;

    case 'payments':
        $controller = new PaymentController($pdo);
        if ($method === 'POST' && isset($_POST['_action']) && $_POST['_action'] === 'create') $controller->store();
        elseif (isset($_GET['action']) && $_GET['action'] === 'create') $controller->create();
        else $controller->index();
        break;

    default:
        http_response_code(404);
        echo "Route not found";
}
