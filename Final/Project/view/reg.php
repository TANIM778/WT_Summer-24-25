<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
unset($_SESSION['errors'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register — Bank Management System</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <form action="../php/reg_valid.php" method="post">
    <fieldset>
      <legend>Customer Registration</legend>
      <?php foreach ($errors as $error): ?>
        <p role="alert" style="color:red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
      <?php endforeach; ?>
      <?php if ($success !== ''): ?>
        <p role="status" style="color:green;"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>
      <input type="hidden" name="role" value="customer">
      <table>
        <tr><td><label for="email">Email:</label></td><td><input type="email" id="email" name="email" required></td></tr>
        <tr><td><label for="fname">Full name:</label></td><td><input type="text" id="fname" name="fname" maxlength="120" required></td></tr>
        <tr><td><label for="uname">Username:</label></td><td><input type="text" id="uname" name="uname" pattern="[a-z0-9]{3,32}" required></td></tr>
        <tr><td><label for="password">Password:</label></td><td><input type="password" id="password" name="password" minlength="8" required></td></tr>
        <tr><td><label for="cpassword">Confirm password:</label></td><td><input type="password" id="cpassword" name="cpassword" minlength="8" required></td></tr>
        <tr><td><label for="phone">Phone:</label></td><td><input type="tel" id="phone" name="phone" maxlength="30" required></td></tr>
        <tr><td>Gender:</td><td><label><input type="radio" name="gender" value="Male" required> Male</label> <label><input type="radio" name="gender" value="Female"> Female</label></td></tr>
        <tr><td><label for="address">Address:</label></td><td><input type="text" id="address" name="address"></td></tr>
        <tr><td><label for="account_type">Account type:</label></td><td><select id="account_type" name="account_type" required><option value="savings">Savings</option><option value="current">Current</option><option value="fixed">Fixed Deposit</option></select></td></tr>
        <tr><td><label for="nid">National ID:</label></td><td><input type="text" id="nid" name="nid" maxlength="50" required></td></tr>
        <tr><td colspan="2"><button type="submit">Register</button></td></tr>
        <tr><td colspan="2"><a href="login.php">Already have an account? Sign in</a></td></tr>
      </table>
    </fieldset>
  </form>
</body>
</html>