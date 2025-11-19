<?php
// src/views/properties/list.php
if (!session_id()) session_start();
$props = $properties ?? [];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Properties - RentEase</title>
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
    <div class="title">Properties</div>
    <?php if($msg = flash('success')): ?>
        <div class="flash"><?=htmlspecialchars($msg)?></div>
    <?php endif; ?>
    <a href="index.php?route=properties&action=create" class="btn">Add Property</a>
    <table class="table" style="margin-top:12px;">
        <tr><th>ID</th><th>Title</th><th>Owner</th><th>City</th><th>Rent</th><th>Status</th><th>Actions</th></tr>
        <?php foreach($props as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?=htmlspecialchars($p['title'])?></td>
                <td><?=htmlspecialchars($p['owner_name'])?></td>
                <td><?=htmlspecialchars($p['city'])?></td>
                <td>₹<?=htmlspecialchars($p['rent_amount'])?></td>
                <td><?=htmlspecialchars($p['status'])?></td>
                <td>
                    <a class="btn" href="index.php?route=properties&action=edit&id=<?= $p['id'] ?>">Edit</a>
                    <a class="btn danger" href="index.php?route=properties&action=delete&id=<?= $p['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
