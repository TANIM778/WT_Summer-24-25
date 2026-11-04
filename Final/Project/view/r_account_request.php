<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'employee' || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../db/db.php';
$pending = getPendingAccounts();
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Account Requests</title></head>
<body>
<h2>Approve or reject account requests</h2>
<?php if (!$pending): ?>
    <p>Could not load account requests.</p>
<?php elseif (mysqli_num_rows($pending) === 0): ?>
    <p>No pending account requests.</p>
<?php else: ?>
<table border="1">
<tr><th>ID</th><th>Customer ID</th><th>Type</th><th>Action</th></tr>
<?php while ($row = mysqli_fetch_assoc($pending)): ?>
<tr>
  <td><?= (int) $row['id'] ?></td>
  <td><?= (int) $row['user_id'] ?></td>
  <td><?= htmlspecialchars($row['account_type'], ENT_QUOTES, 'UTF-8') ?></td>
  <td>
    <form method="post" action="../php/account_approval.php">
      <input type="hidden" name="account_id" value="<?= (int) $row['id'] ?>">
      <button name="status" value="approved">Approve</button>
      <button name="status" value="rejected">Reject</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</table>
<?php endif; ?>
</body>
</html>