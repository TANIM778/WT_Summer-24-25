<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Apply for Loan</title>
</head>
<body>
  <h2>Apply for a Loan</h2>

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

  <form method="POST" action="../php/apply_loan_valid.php">
    <label>Loan Type:</label>
    <select name="loan_type" required>
      <option value="personal">Personal</option>
      <option value="education">Education</option>
      <option value="home">Home</option>
    </select><br><br>

    <label>Amount:</label>
    <input type="number" name="amount" required><br><br>

    <label>Duration (months):</label>
    <input type="number" name="duration" required><br><br>

    <input type="hidden" name="customer_id" value="1"><!-- Example customer_id -->

    <button type="submit">Apply</button>
  </form>
</body>
</html>
