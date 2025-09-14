<?php
session_start();
include '../db/db.php';
$db = new Database();
$pending = $db->getPendingAccounts();
?>

<h2>Approve/Reject New Accounts</h2>
<table border="1">
<tr><th>ID</th><th>User</th><th>Type</th><th>Action</th></tr>
<?php while($row = $pending->fetch_assoc()): ?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= $row['user_id'] ?></td>
  <td><?= $row['account_type'] ?></td>
  <td>
    <form method="post" action="../php/account_approval_valid.php">
      <input type="hidden" name="account_id" value="<?= $row['id'] ?>">
      <button name="status" value="approved">Approve</button>
      <button name="status" value="rejected">Reject</button>
    </form>
  </td>
</tr>
<?php endwhile; ?>
</table>
