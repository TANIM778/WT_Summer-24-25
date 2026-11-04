<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'customer' || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../db/db.php';
$accounts = getCustomerAccounts((int) $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Close an Account</title></head>
<body>
<h2>Close an account</h2>
<?php if (isset($_SESSION['success'])): ?><p role="status"><?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?></p><?php unset($_SESSION['success']); endif; ?>
<?php if (isset($_SESSION['errors'])): foreach ($_SESSION['errors'] as $error): ?><p role="alert" style="color:red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p><?php endforeach; unset($_SESSION['errors']); endif; ?>
<?php if (!$accounts): ?>
<p>Could not load accounts.</p>
<?php elseif (mysqli_num_rows($accounts) === 0): ?>
<p>You have no accounts to close.</p>
<?php else: ?>
<table border="1"><tr><th>ID</th><th>Type</th><th>Status</th><th>Action</th></tr>
<?php while ($account = mysqli_fetch_assoc($accounts)): ?>
<tr><td><?= (int) $account['id'] ?></td><td><?= htmlspecialchars($account['account_type'], ENT_QUOTES, 'UTF-8') ?></td><td><?= htmlspecialchars($account['status'], ENT_QUOTES, 'UTF-8') ?></td><td>
<?php if (in_array($account['status'], ['pending', 'approved'], true)): ?>
<form method="post" action="../php/close_account_valid.php"><input type="hidden" name="account_id" value="<?= (int) $account['id'] ?>"><button type="submit">Request closure</button></form>
<?php else: ?>Not available<?php endif; ?>
</td></tr>
<?php endwhile; ?>
</table>
<?php endif; ?>
</body>
</html>