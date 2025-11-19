<?php
// src/Helpers.php

function view($path, $data = []) {
    $parts = explode('/', $path);
    $file = __DIR__ . '/views/' . implode('/', $parts) . '.php';
    if (!file_exists($file)) {
        echo "View not found: $file";
        return;
    }
    extract($data);
    include $file;
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function flash($name, $message = null) {
    if (!session_id()) session_start();
    if ($message === null) {
        if (isset($_SESSION['flash'][$name])) {
            $msg = $_SESSION['flash'][$name];
            unset($_SESSION['flash'][$name]);
            return $msg;
        }
        return null;
    }
    $_SESSION['flash'][$name] = $message;
}
