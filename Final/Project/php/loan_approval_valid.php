<?php
session_start();
require_once '../db/db.php';

if (($_SESSION['role'] ?? '') !== 'customer' || empty($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/apply_loan.php');
    exit;
}

$loan_type = $_POST['loan_type'] ?? '';
$amount = $_POST['amount'] ?? '';
$duration = $_POST['duration'] ?? '';
$errors = [];
if (!in_array($loan_type, ['personal', 'education', 'home'], true)) $errors[] = 'Select a valid loan type.';
if ($amount === '' || !is_numeric($amount) || !is_finite((float) $amount) || (float) $amount <= 0) $errors[] = 'Amount must be a valid positive number.';
if (filter_var($duration, FILTER_VALIDATE_INT) === false || (int) $duration < 1) $errors[] = 'Duration must be a positive number of months.';

if ($errors) {
    $_SESSION['errors'] = $errors;
} elseif (applyLoan((int) $_SESSION['user_id'], $loan_type, (float) $amount, (int) $duration)) {
    $_SESSION['success'] = 'Loan application submitted successfully.';
} else {
    $_SESSION['errors'] = ['The loan application could not be saved.'];
}

header('Location: ../view/apply_loan.php');
exit;
?>