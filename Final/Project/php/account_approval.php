<?php
include '../db/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['account_id'];
    $status = $_POST['status'];

    if (approveRejectAccount($id, $status)) {
        header("Location: ../view/account_approval.php");
        exit();
    } else {
        echo "Error updating account status.";
    }
}
?>
