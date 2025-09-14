<?php
session_start();
include '../db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'] ?? '';
    $loan_type   = $_POST['loan_type'] ?? '';
    $amount      = $_POST['amount'] ?? '';
    $duration    = $_POST['duration'] ?? '';

    $errors = [];

    if (empty($customer_id) || empty($loan_type) || empty($amount) || empty($duration)) {
        $errors[] = "All fields are required.";
    }
    if ($amount <= 0) {
        $errors[] = "Amount must be greater than 0.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../view/apply_loan.php");
        exit;
    }

    if (applyLoan($customer_id, $loan_type, $amount, $duration)) {
        $_SESSION['success'] = "Loan application submitted successfully!";
    } else {
        $_SESSION['errors'] = ["Error submitting loan application."];
    }

    header("Location: ../view/apply_loan.php");
    exit;
}
?>
