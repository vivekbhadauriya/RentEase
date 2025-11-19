<?php
// src/controllers/PropertyController.php

require_once __DIR__ . '/../models/Property.php';

class PropertyController {
    private $propertyModel;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->propertyModel = new Property($pdo);
    }

    public function index() {
        $properties = $this->propertyModel->all();
        include __DIR__ . '/../views/properties/list.php';
    }

    public function create() {
        $owners = $this->pdo->query('SELECT id, name FROM users')->fetchAll();
        include __DIR__ . '/../views/properties/form.php';
    }

    public function store() {
        $data = [
            'owner_id' => $_POST['owner_id'] ?? 1,
            'title' => $_POST['title'] ?? '',
            'address' => $_POST['address'] ?? '',
            'city' => $_POST['city'] ?? '',
            'rent_amount' => $_POST['rent_amount'] ?? 0,
            'status' => $_POST['status'] ?? 'available'
        ];
        $id = $this->propertyModel->create($data);
        flash('success', 'Property created successfully');
        redirect('index.php?route=properties');
    }

    public function edit($id) {
        $property = $this->propertyModel->find($id);
        $owners = $this->pdo->query('SELECT id, name FROM users')->fetchAll();
        include __DIR__ . '/../views/properties/form.php';
    }

    public function update($id) {
        $data = [
            'title' => $_POST['title'] ?? '',
            'address' => $_POST['address'] ?? '',
            'city' => $_POST['city'] ?? '',
            'rent_amount' => $_POST['rent_amount'] ?? 0,
            'status' => $_POST['status'] ?? 'available'
        ];
        $this->propertyModel->update($id, $data);
        flash('success', 'Property updated');
        redirect('index.php?route=properties');
    }

    public function destroy($id) {
        $this->propertyModel->delete($id);
        flash('success', 'Property deleted');
        redirect('index.php?route=properties');
    }
}
