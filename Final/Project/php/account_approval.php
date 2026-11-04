<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'employee' || empty($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}
require_once '../db/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/r_account_request.php');
    exit;
}
$account_id = filter_var($_POST['account_id'] ?? '', FILTER_VALIDATE_INT);
$status = $_POST['status'] ?? '';
if (!$account_id || !in_array($status, ['approved', 'rejected'], true)) {
    $_SESSION['errors'] = ['Invalid account request.'];
} elseif (!approveRejectAccount($account_id, $status)) {
    $_SESSION['errors'] = ['The account request could not be updated.'];
} else {
    $_SESSION['success'] = 'Account request updated.';
}
header('Location: ../view/r_account_request.php');
exit;
?>