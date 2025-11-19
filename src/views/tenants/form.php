<?php
// src/views/tenants/form.php
if (!session_id()) session_start();
$editing = isset($tenant);
$properties = $properties ?? $pdo->query('SELECT id,title FROM properties')->fetchAll();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $editing ? 'Edit' : 'Add' ?> Tenant</title>
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
    <div class="title"><?= $editing ? 'Edit' : 'Add' ?> Tenant</div>

    <form method="post" action="index.php?route=tenants">
        <?php if($editing): ?>
            <input type="hidden" name="_action" value="update">
            <input type="hidden" name="id" value="<?= $tenant['id'] ?>">
        <?php else: ?>
            <input type="hidden" name="_action" value="create">
        <?php endif; ?>

        <div class="form-group">
            <label>Property</label>
            <select name="property_id" required>
                <?php foreach($properties as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= $editing && $p['id']==$tenant['property_id'] ? 'selected' : '' ?>><?=htmlspecialchars($p['title'])?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?= $editing ? htmlspecialchars($tenant['name']) : '' ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="<?= $editing ? htmlspecialchars($tenant['email']) : '' ?>">
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= $editing ? htmlspecialchars($tenant['phone']) : '' ?>">
        </div>

        <div class="form-group">
            <label>Move-in Date</label>
            <input type="date" name="move_in" value="<?= $editing ? htmlspecialchars($tenant['move_in']) : '' ?>">
        </div>

        <div class="form-group">
            <label>Rent due day (1-31)</label>
            <input type="number" name="rent_due_day" min="1" max="31" value="<?= $editing ? htmlspecialchars($tenant['rent_due_day']) : '1' ?>">
        </div>

        <button class="btn" type="submit"><?= $editing ? 'Update' : 'Create' ?></button>
    </form>
</div>
</body>
</html>
