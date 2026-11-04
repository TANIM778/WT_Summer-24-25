<?php
session_start();
require_once '../db/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/login.php');
    exit;
}

$role = $_POST['role'] ?? '';
$uname = trim($_POST['uname'] ?? '');
$password = $_POST['password'] ?? '';
if (!in_array($role, ['customer', 'employee'], true) || $uname === '' || $password === '') {
    $_SESSION['errors'] = ['Enter your role, username, and password.'];
    header('Location: ../view/login.php');
    exit;
}

$user = get_user_by_role($role, $uname);
$stored_password = (string) ($user['password'] ?? '');
$valid = $user && (
    password_verify($password, $stored_password)
    || hash_equals($stored_password, $password)
);

if (!$valid) {
    $_SESSION['errors'] = ['Invalid username or password.'];
    header('Location: ../view/login.php');
    exit;
}

// Upgrade legacy plain-text passwords at the next successful sign-in.
if (!password_verify($password, $stored_password)) {
    update_user_password($role, (int) $user['id'], password_hash($password, PASSWORD_DEFAULT));
}

session_regenerate_id(true);
$_SESSION['role'] = $role;
$_SESSION['uname'] = $user['uname'];
$_SESSION['username'] = $user['uname']; // Keep the legacy key for other existing pages.
$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['name'] = $user['fname'];

$redirect = $role === 'customer' ? '../view/c_dashboard.php' : '../view/e_dashboard.php';
header('Location: ' . $redirect);
exit;
?>