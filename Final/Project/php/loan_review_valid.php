<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'employee' || empty($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}
require_once '../db/db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/loan_review.php');
    exit;
}
$loan_id = filter_var($_POST['loan_id'] ?? '', FILTER_VALIDATE_INT);
$status = $_POST['status'] ?? '';
if (!$loan_id || !in_array($status, ['approved', 'rejected'], true)) {
    $_SESSION['errors'] = ['Invalid loan review request.'];
} elseif (!approveRejectLoan($loan_id, $status)) {
    $_SESSION['errors'] = ['The loan application could not be updated.'];
} else {
    $_SESSION['success'] = 'Loan application updated.';
}
header('Location: ../view/loan_review.php');
exit;
?>