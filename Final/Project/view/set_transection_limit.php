<?php
session_start();
include '../db/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
    $account_id = $_POST['account_id'] ?? '';
    $limit = $_POST['limit'] ?? '';
    $lock = $_POST['lock'] ?? '';

    $errors = [];

    if (empty($account_id)) $errors[] = "Account ID is required.";
    if ($limit === '' || !is_numeric($limit) || $limit < 0) 
        {
            $errors[] = "Transaction limit must be a positive number.";
        }

    if (!empty($errors)) 
        {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header("Location: ../view/set_transaction_limit.php");
            exit;
        }

    // Update transaction limit
    setTransactionLimit($account_id, $limit);

    // Handle debit card lock
    if ($lock !== '') 
        {
            $status = ($lock === "1") ? 1 : 0;
            lockDebitCard($account_id, $status);
        }

    $_SESSION['success'] = "Transaction limit updated successfully!";
    header("Location: ../view/set_transaction_limit.php");
    exit;
}
?>
