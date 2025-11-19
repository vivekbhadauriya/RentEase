<?php
// src/views/dashboard.php
if (!session_id()) session_start();
$pdo = Database::getInstance()->pdo();
$propCount = $pdo->query('SELECT COUNT(*) as c FROM properties')->fetch()['c'];
$tenantCount = $pdo->query('SELECT COUNT(*) as c FROM tenants')->fetch()['c'];
$recentPayments = $pdo->query('SELECT pay.*, t.name as tenant_name FROM payments pay JOIN tenants t ON pay.tenant_id = t.id ORDER BY pay.created_at DESC LIMIT 5')->fetchAll();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>RentEase - Dashboard</title>
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
    <div class="title">Dashboard</div>
    <?php if($msg = flash('success')): ?>
        <div class="flash"><?=htmlspecialchars($msg)?></div>
    <?php endif; ?>
    <div>
        <strong>Properties:</strong> <?= $propCount ?> |
        <strong>Tenants:</strong> <?= $tenantCount ?>
    </div>

    <h3 style="margin-top:18px;">Recent Payments</h3>
    <table class="table">
        <tr><th>Tenant</th><th>Amount</th><th>Paid On</th><th>Note</th></tr>
        <?php foreach($recentPayments as $p): ?>
            <tr>
                <td><?=htmlspecialchars($p['tenant_name'])?></td>
                <td><?=htmlspecialchars($p['amount'])?></td>
                <td><?=htmlspecialchars($p['paid_on'])?></td>
                <td class="small"><?=htmlspecialchars($p['note'])?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
