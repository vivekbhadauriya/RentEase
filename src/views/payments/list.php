<?php
// src/views/payments/list.php
if (!session_id()) session_start();
$payments = $payments ?? [];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payments - RentEase</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<nav>
    <a href="index.php?route=dashboard">Dashboard</a> |
    <a href="index.php?route=properties">Properties</a> |
    <a href="index.php?route=tenants">Tenants</a> |
    <a href="index.php?route=payments">Payments</a>
</nav>
<div class="container">
    <div class="title">Payments</div>
    <?php if($msg = flash('success')): ?>
        <div class="flash"><?=htmlspecialchars($msg)?></div>
    <?php endif; ?>
    <a href="index.php?route=payments&action=create" class="btn">Record Payment</a>
    <table class="table" style="margin-top:12px;">
        <tr><th>ID</th><th>Tenant</th><th>Property</th><th>Amount</th><th>Paid On</th><th>Method</th></tr>
        <?php foreach($payments as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?=htmlspecialchars($p['tenant_name'])?></td>
                <td><?=htmlspecialchars($p['property_title'])?></td>
                <td>₹<?=htmlspecialchars($p['amount'])?></td>
                <td><?=htmlspecialchars($p['paid_on'])?></td>
                <td><?=htmlspecialchars($p['payment_method'])?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
