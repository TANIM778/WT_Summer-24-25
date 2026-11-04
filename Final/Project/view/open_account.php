<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'customer' || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Open Bank Account</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<main>
    <h2>Open Bank Account</h2>
    <?php foreach ($errors as $error): ?>
        <p role="alert" style="color:red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endforeach; ?>
    <?php if ($success !== ''): ?>
        <p role="status" style="color:green;"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>
    <form method="post" action="../php/open_accounta_valid.php">
        <label for="account_type">Account type</label>
        <select id="account_type" name="account_type" required>
            <option value="Savings" <?= ($old['account_type'] ?? '') === 'Savings' ? 'selected' : '' ?>>Savings</option>
            <option value="Current" <?= ($old['account_type'] ?? '') === 'Current' ? 'selected' : '' ?>>Current</option>
            <option value="Fixed Deposit" <?= ($old['account_type'] ?? '') === 'Fixed Deposit' ? 'selected' : '' ?>>Fixed Deposit</option>
        </select>
        <label for="initial_deposit">Initial deposit</label>
        <input id="initial_deposit" type="number" min="0" step="0.01" name="initial_deposit" value="<?= htmlspecialchars($old['initial_deposit'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        <button type="submit">Submit account request</button>
    </form>
    <p><a href="c_dashboard.php">Back to dashboard</a></p>
</main>
</body>
</html>