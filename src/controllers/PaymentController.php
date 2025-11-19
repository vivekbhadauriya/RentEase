<?php
// src/controllers/PaymentController.php

class PaymentController {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $stmt = $this->pdo->query('SELECT pay.*, t.name as tenant_name, p.title as property_title FROM payments pay JOIN tenants t ON pay.tenant_id = t.id JOIN properties p ON t.property_id = p.id ORDER BY pay.created_at DESC');
        $payments = $stmt->fetchAll();
        include __DIR__ . '/../views/payments/list.php';
    }

    public function create() {
        $stmt = $this->pdo->query('SELECT id, name FROM tenants');
        $tenants = $stmt->fetchAll();
        include __DIR__ . '/../views/payments/form.php';
    }

    public function store() {
        $stmt = $this->pdo->prepare('INSERT INTO payments (tenant_id,amount,paid_on,payment_method,note) VALUES (:tenant_id,:amount,:paid_on,:payment_method,:note)');
        $stmt->execute([
            'tenant_id'=>$_POST['tenant_id'],
            'amount'=>$_POST['amount'],
            'paid_on'=>$_POST['paid_on'],
            'payment_method'=>$_POST['payment_method'],
            'note'=>$_POST['note'] ?? ''
        ]);
        flash('success','Payment recorded');
        redirect('index.php?route=payments');
    }
}
