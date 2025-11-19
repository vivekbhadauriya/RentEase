<?php
// src/views/payments/form.php
if (!session_id()) session_start();
$tenants = $tenants ?? $pdo->query('SELECT id,name FROM tenants')->fetchAll();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Record Payment - RentEase</title>
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
    <div class="title">Record Payment</div>

    <form method="post" action="index.php?route=payments">
        <input type="hidden" name="_action" value="create">

        <div class="form-group">
            <label>Tenant</label>
            <select name="tenant_id" required>
                <?php foreach($tenants as $t): ?>
                    <option value="<?= $t['id'] ?>"><?=htmlspecialchars($t['name'])?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" required>
        </div>

        <div class="form-group">
            <label>Paid On</label>
            <input type="date" name="paid_on" required value="<?= date('Y-m-d') ?>">
        </div>

        <div class="form-group">
            <label>Payment Method</label>
            <input type="text" name="payment_method" placeholder="Cash / UPI / Bank Transfer">
        </div>

        <div class="form-group">
            <label>Note</label>
            <textarea name="note"></textarea>
        </div>

        <button class="btn" type="submit">Record</button>
    </form>
</div>
</body>
</html>
