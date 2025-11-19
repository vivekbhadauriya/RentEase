<?php
// src/models/Property.php

class Property {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $stmt = $this->pdo->query("SELECT p.*, u.name as owner_name FROM properties p JOIN users u ON p.owner_id = u.id ORDER BY p.created_at DESC");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM properties WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare('INSERT INTO properties (owner_id,title,address,city,rent_amount,status) VALUES (:owner_id,:title,:address,:city,:rent_amount,:status)');
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data) {
        $data['id'] = $id;
        $stmt = $this->pdo->prepare('UPDATE properties SET title=:title,address=:address,city=:city,rent_amount=:rent_amount,status=:status WHERE id=:id');
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare('DELETE FROM properties WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
