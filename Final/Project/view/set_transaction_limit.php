<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'employee' || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
unset($_SESSION['errors'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Manage Transaction Limits</title></head>
<body>
<h2>Manage transaction limit and card lock</h2>
<?php foreach ($errors as $error): ?><p role="alert" style="color:red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p><?php endforeach; ?>
<?php if ($success !== ''): ?><p role="status" style="color:green;"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
<form method="post" action="../php/set_transaction_limit_valid.php">
  <label>Account ID <input type="number" name="account_id" min="1" required></label><br>
  <label>Transaction limit <input type="number" name="limit" min="0" step="0.01" required></label><br>
  <label>Debit card
    <select name="lock"><option value="">Leave unchanged</option><option value="1">Lock</option><option value="0">Unlock</option></select>
  </label><br>
  <button type="submit">Save</button>
</form>
</body>
</html>