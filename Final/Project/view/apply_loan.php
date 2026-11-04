<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'customer' || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
unset($_SESSION['errors'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Apply for Loan</title>
</head>
<body>
  <h2>Apply for a Loan</h2>
  <?php foreach ($errors as $error): ?>
    <p role="alert" style="color:red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
  <?php endforeach; ?>
  <?php if ($success !== ''): ?>
    <p role="status" style="color:green;"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
  <?php endif; ?>
  <form method="post" action="../php/loan_approval_valid.php">
    <label for="loan_type">Loan type</label>
    <select id="loan_type" name="loan_type" required>
      <option value="personal">Personal</option>
      <option value="education">Education</option>
      <option value="home">Home</option>
    </select><br><br>
    <label for="amount">Amount</label>
    <input id="amount" type="number" name="amount" min="0.01" step="0.01" required><br><br>
    <label for="duration">Duration (months)</label>
    <input id="duration" type="number" name="duration" min="1" step="1" required><br><br>
    <button type="submit">Apply</button>
  </form>
</body>
</html>