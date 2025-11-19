<?php
// src/views/properties/form.php
if (!session_id()) session_start();
$editing = isset($property);
$owners = $owners ?? $pdo->query('SELECT id,name FROM users')->fetchAll();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $editing ? 'Edit' : 'Add' ?> Property</title>
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
    <div class="title"><?= $editing ? 'Edit' : 'Add' ?> Property</div>

    <form method="post" action="index.php?route=properties">
        <?php if($editing): ?>
            <input type="hidden" name="_action" value="update">
            <input type="hidden" name="id" value="<?= $property['id'] ?>">
        <?php else: ?>
            <input type="hidden" name="_action" value="create">
        <?php endif; ?>

        <div class="form-group">
            <label>Owner</label>
            <select name="owner_id" required>
                <?php foreach($owners as $o): ?>
                    <option value="<?= $o['id'] ?>" <?= $editing && $o['id']==$property['owner_id'] ? 'selected' : '' ?>><?=htmlspecialchars($o['name'])?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?= $editing ? htmlspecialchars($property['title']) : '' ?>" required>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address"><?= $editing ? htmlspecialchars($property['address']) : '' ?></textarea>
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" name="city" value="<?= $editing ? htmlspecialchars($property['city']) : '' ?>">
        </div>

        <div class="form-group">
            <label>Rent Amount</label>
            <input type="number" step="0.01" name="rent_amount" value="<?= $editing ? htmlspecialchars($property['rent_amount']) : '' ?>">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option value="available" <?= $editing && $property['status']=='available' ? 'selected' : '' ?>>Available</option>
                <option value="occupied" <?= $editing && $property['status']=='occupied' ? 'selected' : '' ?>>Occupied</option>
                <option value="maintenance" <?= $editing && $property['status']=='maintenance' ? 'selected' : '' ?>>Maintenance</option>
            </select>
        </div>

        <button class="btn" type="submit"><?= $editing ? 'Update' : 'Create' ?></button>
    </form>
</div>
</body>
</html>
