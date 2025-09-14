<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "project";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// ---------------- Customer & Employee Inserts ----------------
function insert_customer($data) {
    global $conn;
    $sql = "INSERT INTO customer 
        (fname, uname, email, password, phone, gender, address, account_type, nid) 
        VALUES 
        ('{$data['fname']}', '{$data['uname']}', '{$data['email']}', '{$data['password']}', 
         '{$data['phone']}', '{$data['gender']}', '{$data['address']}', '{$data['account_type']}', '{$data['nid']}')";
    return mysqli_query($conn, $sql);
}

function insert_employee($data) {
    global $conn;
    $sql = "INSERT INTO employee 
        (fname, uname, email, password, phone, gender, department) 
        VALUES 
        ('{$data['fname']}', '{$data['uname']}', '{$data['email']}', '{$data['password']}', 
         '{$data['phone']}', '{$data['gender']}', '{$data['department']}')";
    return mysqli_query($conn, $sql);
}

// ---------------- Fetching Customers & Employees ----------------
function get_all_customers() {
    global $conn;
    $sql = "SELECT * FROM customer";
    return mysqli_query($conn, $sql);
}

function get_all_employees() {
    global $conn;
    $sql = "SELECT * FROM employee";
    return mysqli_query($conn, $sql);
}

// ---------------- Account Management ----------------
function getPendingAccounts() {
    global $conn;
    $sql = "SELECT * FROM accounts WHERE status='pending'";
    return mysqli_query($conn, $sql);
}

function approveRejectAccount($account_id, $status) {
    global $conn;
    $sql = "UPDATE accounts SET status='$status' WHERE id='$account_id'";
    return mysqli_query($conn, $sql);
}

function getLoanApplications() {
    global $conn;
    $sql = "SELECT * FROM loans WHERE status='under_review'";
    return mysqli_query($conn, $sql);
}

function verifyLoan($loan_id, $verified) {
    global $conn;
    $sql = "UPDATE loans SET verified='$verified' WHERE id='$loan_id'";
    return mysqli_query($conn, $sql);
}

function approveRejectLoan($loan_id, $status) {
    global $conn;
    $sql = "UPDATE loans SET status='$status' WHERE id='$loan_id'";
    return mysqli_query($conn, $sql);
}

function manageFD($fd_id, $action) {
    global $conn;
    $sql = "UPDATE fixed_deposits SET status='$action' WHERE id='$fd_id'";
    return mysqli_query($conn, $sql);
}

function closeAccount($account_id) {
    global $conn;
    $sql = "UPDATE accounts SET status='closed' WHERE id='$account_id'";
    return mysqli_query($conn, $sql);
}

function getCustomerHistory($customer_id) {
    global $conn;
    $data = [];
    $data['accounts'] = mysqli_query($conn, "SELECT * FROM accounts WHERE user_id='$customer_id'");
    $data['transactions'] = mysqli_query($conn, "SELECT * FROM transactions WHERE user_id='$customer_id'");
    $data['loans'] = mysqli_query($conn, "SELECT * FROM loans WHERE user_id='$customer_id'");
    return $data;
}

function setTransactionLimit($account_id, $limit) {
    global $conn;
    $sql = "UPDATE accounts SET transaction_limit='$limit' WHERE id='$account_id'";
    return mysqli_query($conn, $sql);
}

function lockDebitCard($account_id, $status) {
    global $conn;
    $sql = "UPDATE accounts SET card_locked='$status' WHERE id='$account_id'";
    return mysqli_query($conn, $sql);
}

function openAccount($user_id, $account_type, $initial_deposit) {
    global $conn;
    $sql = "INSERT INTO accounts (user_id, account_type, balance, status) 
            VALUES ('$user_id', '$account_type', '$initial_deposit', 'pending')";

    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return "Database error: " . mysqli_error($conn);
    }
}

// ---------------- Close Connection ----------------
function close_connection() {
    global $conn;
    mysqli_close($conn);
}
?>
