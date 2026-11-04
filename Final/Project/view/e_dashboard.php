<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'employee' || empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <main>
        <h1>Welcome, <?= htmlspecialchars($_SESSION['name'] ?? 'Employee', ENT_QUOTES, 'UTF-8') ?>!</h1>
        <ul>
            <li><a href="r_account_request.php">Review account requests</a></li>
            <li><a href="loan_review.php">Review loan applications</a></li>
            <li><a href="set_transaction_limit.php">Manage transaction limits</a></li>
        </ul>
        <form action="../php/logout.php" method="post"><button type="submit">Logout</button></form>
    </main>
</body>
</html>