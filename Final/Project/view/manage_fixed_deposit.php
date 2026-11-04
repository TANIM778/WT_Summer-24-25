<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'employee' || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../db/db.php';
$deposits = getPendingFixedDeposits();
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Fixed Deposit Requests</title></head>
<body>
<h2>Review fixed-deposit requests</h2>
<?php if (!$deposits): ?>
<p>Could not load fixed-deposit requests.</p>
<?php elseif (mysqli_num_rows($deposits) === 0): ?>
<p>No pending fixed-deposit requests.</p>
<?php else: ?>
<table border="1"><tr><th>ID</th><th>Action</th></tr>
<?php while ($deposit = mysqli_fetch_assoc($deposits)): ?>
<tr><td><?= (int) $deposit['id'] ?></td><td>
<form method="post" action="../php/manage_fd_valid.php"><input type="hidden" name="fd_id" value="<?= (int) $deposit['id'] ?>"><button name="action" value="approved">Approve</button><button name="action" value="rejected">Reject</button></form>
</td></tr>
<?php endwhile; ?>
</table>
<?php endif; ?>
</body>
</html>