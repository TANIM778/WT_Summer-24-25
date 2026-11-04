<?php
session_start();
if (($_SESSION['role'] ?? '') !== 'employee' || empty($_SESSION['user_id'])) {
    header('Location: ../view/login.php');
    exit;
}
require_once '../db/db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/manage_fixed_deposit.php');
    exit;
}
$fd_id = filter_var($_POST['fd_id'] ?? '', FILTER_VALIDATE_INT);
$action = $_POST['action'] ?? '';
if (!$fd_id || !manageFD($fd_id, $action)) {
    $_SESSION['errors'] = ['The fixed-deposit request could not be updated.'];
} else {
    $_SESSION['success'] = 'Fixed-deposit request updated.';
}
header('Location: ../view/manage_fixed_deposit.php');
exit;
?>