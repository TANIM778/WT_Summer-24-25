<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Deposit / Withdraw</title>
</head>
<body>
  <h2>Deposit / Withdraw Funds</h2>

  <?php 
  if (isset($_SESSION['errors'])) {
      foreach ($_SESSION['errors'] as $error) {
          echo "<p style='color:red;'>$error</p>";
      }
      unset($_SESSION['errors']);
  }
  if (isset($_SESSION['success'])) {
      echo "<p style='color:green;'>".$_SESSION['success']."</p>";
      unset($_SESSION['success']);
  }
  ?>

  <form method="POST" action="../php/deposit_withdraw_valid.php">
    <label>Account ID:</label>
    <input type="text" name="account_id" required><br><br>

    <label>Transaction Type:</label>
    <select name="type" required>
      <option value="deposit">Deposit</option>
      <option value="withdraw">Withdraw</option>
    </select><br><br>

    <label>Amount:</label>
    <input type="number" name="amount" required><br><br>

    <button type="submit">Submit</button>
  </form>
</body>
</html>
