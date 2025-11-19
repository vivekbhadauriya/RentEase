<?php
// src/Database.php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct($config) {
        $db = $config['db'];
        $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset={$db['charset']}";
        $this->pdo = new PDO($dsn, $db['user'], $db['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public static function getInstance($config = null) {
        if (self::$instance === null) {
            if ($config === null) throw new Exception('Database not configured');
            self::$instance = new Database($config);
        }
        return self::$instance;
    }

    public function pdo() {
        return $this->pdo;
    }
}
