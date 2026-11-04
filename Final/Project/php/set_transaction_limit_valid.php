<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'employee' || empty($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}
require_once '../db/db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/set_transaction_limit.php');
    exit;
}

$account_id = filter_var($_POST['account_id'] ?? '', FILTER_VALIDATE_INT);
$limit = $_POST['limit'] ?? '';
$lock = $_POST['lock'] ?? '';
if (!$account_id || $limit === '' || !is_numeric($limit) || !is_finite((float) $limit) || (float) $limit < 0 || !in_array($lock, ['', '0', '1'], true)) {
    $_SESSION['errors'] = ['Enter a valid account ID, non-negative limit, and card-lock setting.'];
    header('Location: ../view/set_transaction_limit.php');
    exit;
}
if (!setTransactionLimit($account_id, (float) $limit) || ($lock !== '' && !lockDebitCard($account_id, (int) $lock))) {
    $_SESSION['errors'] = ['The account settings could not be updated.'];
} else {
    $_SESSION['success'] = 'Account settings updated.';
}
header('Location: ../view/set_transaction_limit.php');
exit;
?>