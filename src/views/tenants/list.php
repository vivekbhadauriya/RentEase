<?php
// src/views/tenants/list.php
if (!session_id()) session_start();
$tenants = $tenants ?? [];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tenants - RentEase</title>
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
    <div class="title">Tenants</div>
    <?php if($msg = flash('success')): ?>
        <div class="flash"><?=htmlspecialchars($msg)?></div>
    <?php endif; ?>
    <a href="index.php?route=tenants&action=create" class="btn">Add Tenant</a>
    <table class="table" style="margin-top:12px;">
        <tr><th>ID</th><th>Name</th><th>Property</th><th>Phone</th><th>Move In</th><th>Actions</th></tr>
        <?php foreach($tenants as $t): ?>
            <tr>
                <td><?= $t['id'] ?></td>
                <td><?=htmlspecialchars($t['name'])?></td>
                <td><?=htmlspecialchars($t['property_title'])?></td>
                <td><?=htmlspecialchars($t['phone'])?></td>
                <td><?=htmlspecialchars($t['move_in'])?></td>
                <td>
                    <a class="btn" href="index.php?route=tenants&action=edit&id=<?= $t['id'] ?>">Edit</a>
                    <a class="btn danger" href="index.php?route=tenants&action=delete&id=<?= $t['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
