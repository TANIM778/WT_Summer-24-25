<?php
session_start();
require_once '../db/db.php';

if (($_SESSION['role'] ?? '') !== 'customer' || empty($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/open_account.php');
    exit;
}

$account_type = $_POST['account_type'] ?? '';
$deposit = $_POST['initial_deposit'] ?? '';
$allowed_types = ['Savings', 'Current', 'Fixed Deposit'];
$errors = [];
if (!in_array($account_type, $allowed_types, true)) $errors[] = 'Select a valid account type.';
if ($deposit === '' || !is_numeric($deposit) || !is_finite((float) $deposit) || (float) $deposit < 0) {
    $errors[] = 'Initial deposit must be a valid non-negative amount.';
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = ['account_type' => $account_type, 'initial_deposit' => $deposit];
    header('Location: ../view/open_account.php');
    exit;
}

if (openAccount((int) $_SESSION['user_id'], $account_type, (float) $deposit)) {
    $_SESSION['success'] = 'Account request submitted for approval.';
} else {
    $_SESSION['errors'] = ['The account request could not be saved.'];
}
header('Location: ../view/open_account.php');
exit;
?>