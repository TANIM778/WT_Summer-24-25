<?php
session_start();
include '../db/db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
    {
    $user_id = $_POST['user_id'] ?? '';
    $account_type = $_POST['account_type'] ?? '';
    $initial_deposit = $_POST['initial_deposit'] ?? '';

    // Validation
    if (empty($user_id)) $errors[] = "User ID is required.";
    if (empty($account_type)) $errors[] = "Account type is required.";
    if ($initial_deposit === '' || !is_numeric($initial_deposit) || $initial_deposit < 0) {
        $errors[] = "Initial deposit must be a positive number.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header("Location: ../view/open_account.php");
        exit;
    } 
    else 
    {
        $result = openAccount($user_id, $account_type, $initial_deposit);

        if ($result === true) {
            $_SESSION['success'] = "Account opened successfully!";
            header("Location: ../view/open_account.php");
            exit;
        } else {
            $_SESSION['errors'] = [$result];
            $_SESSION['old'] = $_POST;
            header("Location: ../view/open_account.php");
            exit;
        }
    }
}
?>
