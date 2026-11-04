<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'employee' || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../db/db.php';
$applications = getLoanApplications();
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Loan Applications</title></head>
<body>
<h2>Review loan applications</h2>
<?php if (!$applications): ?>
<p>Could not load loan applications.</p>
<?php elseif (mysqli_num_rows($applications) === 0): ?>
<p>No loan applications are waiting for review.</p>
<?php else: ?>
<table border="1">
<tr><th>Loan ID</th><th>Customer ID</th><th>Type</th><th>Amount</th><th>Duration</th><th>Decision</th></tr>
<?php while ($loan = mysqli_fetch_assoc($applications)): ?>
<tr>
<td><?= (int) $loan['id'] ?></td>
<td><?= (int) $loan['user_id'] ?></td>
<td><?= htmlspecialchars($loan['loan_type'], ENT_QUOTES, 'UTF-8') ?></td>
<td><?= htmlspecialchars((string) $loan['amount'], ENT_QUOTES, 'UTF-8') ?></td>
<td><?= (int) $loan['duration'] ?> months</td>
<td><form method="post" action="../php/loan_review_valid.php">
<input type="hidden" name="loan_id" value="<?= (int) $loan['id'] ?>">
<button name="status" value="approved">Approve</button>
<button name="status" value="rejected">Reject</button>
</form></td>
</tr>
<?php endwhile; ?>
</table>
<?php endif; ?>
</body>
</html>