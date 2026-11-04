<?php
session_start();
include '../db/db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/reg.php');
    exit;
}

$role = $_POST['role'] ?? '';
$fname = trim($_POST['fname'] ?? '');
$email = trim($_POST['email'] ?? '');
$uname = trim($_POST['uname'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['cpassword'] ?? '';
$phone = trim($_POST['phone'] ?? '');
$gender = $_POST['gender'] ?? '';
$address = trim($_POST['address'] ?? '');
$account_type = $_POST['account_type'] ?? '';
$nid = trim($_POST['nid'] ?? '');

if ($role !== 'customer') {
    $errors[] = 'Only customer registration is available. Employee accounts must be provisioned by an administrator.';
}
if ($fname === '' || strlen($fname) > 120) $errors[] = 'Enter a valid full name.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
if (!preg_match('/^[a-z0-9]{3,32}$/', $uname)) $errors[] = 'Username must use 3–32 lowercase letters or numbers.';
if (strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
if ($password !== $confirm_password) $errors[] = 'Passwords do not match.';
if ($phone === '' || strlen($phone) > 30) $errors[] = 'Enter a valid phone number.';
if (!in_array($gender, ['Male', 'Female'], true)) $errors[] = 'Select a valid gender.';
if (!in_array($account_type, ['savings', 'current', 'fixed'], true)) $errors[] = 'Select a valid account type.';
if ($nid === '' || strlen($nid) > 50) $errors[] = 'Enter a valid National ID.';

if (!$errors && username_exists($uname)) {
    $errors[] = 'Username already taken. Choose another.';
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    header('Location: ../view/reg.php');
    exit;
}

$data = [
    'fname' => $fname,
    'uname' => $uname,
    'email' => $email,
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'phone' => $phone,
    'gender' => $gender,
    'address' => $address,
    'account_type' => $account_type,
    'nid' => $nid,
];

if (insert_customer($data)) {
    $_SESSION['success'] = 'Registration completed. You can now sign in.';
    header('Location: ../view/login.php');
    exit;
}

$_SESSION['errors'] = ['Registration could not be completed. Please try again.'];
header('Location: ../view/reg.php');
exit;
?>