<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bank Management System — Login</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <form action="../php/login_valid.php" method="post">
    <fieldset>
      <legend>Login to Bank Management System</legend>
      <?php foreach ($errors as $error): ?>
        <p role="alert" style="color:red;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
      <?php endforeach; ?>
      <table>
        <tr><td><label for="role">Role:</label></td><td><select id="role" name="role" required><option value="">Select your role</option><option value="customer">Customer</option><option value="employee">Employee</option></select></td></tr>
        <tr><td><label for="uname">Username:</label></td><td><input type="text" id="uname" name="uname" required autocomplete="username"></td></tr>
        <tr><td><label for="password">Password:</label></td><td><input type="password" id="password" name="password" required autocomplete="current-password"></td></tr>
        <tr><td colspan="2"><button type="submit">Login</button></td></tr>
        <tr><td colspan="2"><a href="reg.php">Register</a></td></tr>
      </table>
    </fieldset>
  </form>
</body>
</html>