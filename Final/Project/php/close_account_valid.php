<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'customer' || empty($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}
require_once '../db/db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/close_account.php');
    exit;
}
$account_id = filter_var($_POST['account_id'] ?? '', FILTER_VALIDATE_INT);
if (!$account_id || !closeAccount($account_id, (int) $_SESSION['user_id'])) {
    $_SESSION['errors'] = ['The account could not be closed. Check the account and its status.'];
} else {
    $_SESSION['success'] = 'Account closed.';
}
header('Location: ../view/close_account.php');
exit;
?>