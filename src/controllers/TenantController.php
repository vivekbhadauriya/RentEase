<?php
// src/controllers/TenantController.php

class TenantController {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $stmt = $this->pdo->query('SELECT t.*, p.title as property_title FROM tenants t JOIN properties p ON t.property_id = p.id ORDER BY t.created_at DESC');
        $tenants = $stmt->fetchAll();
        include __DIR__ . '/../views/tenants/list.php';
    }

    public function create() {
        $propStmt = $this->pdo->query('SELECT id, title FROM properties WHERE status = "available"');
        $properties = $propStmt->fetchAll();
        include __DIR__ . '/../views/tenants/form.php';
    }

    public function store() {
        $stmt = $this->pdo->prepare('INSERT INTO tenants (property_id,name,email,phone,move_in,rent_due_day) VALUES (:property_id,:name,:email,:phone,:move_in,:rent_due_day)');
        $stmt->execute([
            'property_id' => $_POST['property_id'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'move_in' => $_POST['move_in'],
            'rent_due_day' => $_POST['rent_due_day'] ?? 1
        ]);
        $this->pdo->prepare('UPDATE properties SET status = "occupied" WHERE id = :id')->execute(['id' => $_POST['property_id']]);
        flash('success','Tenant added');
        redirect('index.php?route=tenants');
    }

    public function edit($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM tenants WHERE id = :id');
        $stmt->execute(['id'=>$id]);
        $tenant = $stmt->fetch();
        $propStmt = $this->pdo->query('SELECT id, title FROM properties');
        $properties = $propStmt->fetchAll();
        include __DIR__ . '/../views/tenants/form.php';
    }

    public function update($id) {
        $stmt = $this->pdo->prepare('UPDATE tenants SET property_id=:property_id,name=:name,email=:email,phone=:phone,move_in=:move_in,move_out=:move_out,rent_due_day=:rent_due_day WHERE id=:id');
        $stmt->execute([
            'property_id' => $_POST['property_id'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'move_in' => $_POST['move_in'],
            'move_out' => $_POST['move_out'] ?? null,
            'rent_due_day' => $_POST['rent_due_day'] ?? 1,
            'id' => $id
        ]);
        flash('success','Tenant updated');
        redirect('index.php?route=tenants');
    }

    public function destroy($id) {
        $stmt = $this->pdo->prepare('SELECT property_id FROM tenants WHERE id=:id');
        $stmt->execute(['id'=>$id]);
        $row = $stmt->fetch();
        if ($row) {
            $this->pdo->prepare('UPDATE properties SET status = "available" WHERE id = :id')->execute(['id'=>$row['property_id']]);
        }
        $this->pdo->prepare('DELETE FROM tenants WHERE id = :id')->execute(['id'=>$id]);
        flash('success','Tenant removed');
        redirect('index.php?route=tenants');
    }
}
