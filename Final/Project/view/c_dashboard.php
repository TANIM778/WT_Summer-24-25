<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'customer' || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>
        <h1>Welcome, <?= htmlspecialchars($_SESSION['name'] ?? 'Customer', ENT_QUOTES, 'UTF-8') ?>!</h1>
        <p><a href="open_account.php">Open an account</a></p>
        <p><a href="apply_loan.php">Apply for a loan</a></p>
        <form action="../php/logout.php" method="post"><button type="submit">Logout</button></form>
    </main>
</body>
</html>