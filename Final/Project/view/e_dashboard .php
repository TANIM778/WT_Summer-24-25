<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'employee') 
    {
        header("Location: ../view/login.php");
        exit;
    }

include "../db/db.php";


$username = $_SESSION['username'];
$sql = "SELECT * FROM employee WHERE username='$username' LIMIT 1";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>

    <form action="profile.php" method="GET">
        <button type="submit">Full Profile</button>
    </form>

    <form action="../php/logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
