<?php
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$dbname = getenv('DB_NAME') ?: 'project';

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    http_response_code(500);
    exit('Database connection failed.');
}
mysqli_set_charset($conn, 'utf8mb4');

/** Prepare and execute a parameterized statement. */
function execute_prepared($sql, $types = '', $values = []) {
    global $conn;
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return false;

    if ($types !== '') {
        $args = array_merge([$stmt, $types], $values);
        $refs = [];
        foreach ($args as $key => $value) $refs[$key] = &$args[$key];
        if (!call_user_func_array('mysqli_stmt_bind_param', $refs)) {
            mysqli_stmt_close($stmt);
            return false;
        }
    }
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return false;
    }
    return $stmt;
}

function close_statement($stmt) {
    if ($stmt instanceof mysqli_stmt) mysqli_stmt_close($stmt);
}

function insert_customer($data) {
    $stmt = execute_prepared(
        'INSERT INTO customer (fname, uname, email, password, phone, gender, address, account_type, nid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
        'sssssssss',
        [$data['fname'], $data['uname'], $data['email'], $data['password'], $data['phone'], $data['gender'], $data['address'], $data['account_type'], $data['nid']]
    );
    if (!$stmt) return false;
    close_statement($stmt);
    return true;
}

function insert_employee($data) {
    $stmt = execute_prepared(
        'INSERT INTO employee (fname, uname, email, password, phone, gender, department) VALUES (?, ?, ?, ?, ?, ?, ?)',
        'sssssss',
        [$data['fname'], $data['uname'], $data['email'], $data['password'], $data['phone'], $data['gender'], $data['department']]
    );
    if (!$stmt) return false;
    close_statement($stmt);
    return true;
}

function get_user_by_role($role, $uname) {
    $tables = ['customer' => 'customer', 'employee' => 'employee'];
    if (!isset($tables[$role])) return false;
    $table = $tables[$role];
    $stmt = execute_prepared("SELECT id, fname, uname, password FROM $table WHERE uname = ? LIMIT 1", 's', [$uname]);
    if (!$stmt) return false;
    $result = mysqli_stmt_get_result($stmt);
    $user = $result ? mysqli_fetch_assoc($result) : false;
    close_statement($stmt);
    return $user;
}

function update_user_password($role, $user_id, $password_hash) {
    $tables = ['customer' => 'customer', 'employee' => 'employee'];
    if (!isset($tables[$role])) return false;
    $table = $tables[$role];
    $stmt = execute_prepared("UPDATE $table SET password = ? WHERE id = ?", 'si', [$password_hash, $user_id]);
    if (!$stmt) return false;
    close_statement($stmt);
    return true;
}

function username_exists($uname) {
    foreach (['customer', 'employee'] as $table) {
        $stmt = execute_prepared("SELECT id FROM $table WHERE uname = ? LIMIT 1", 's', [$uname]);
        if (!$stmt) return true;
        $result = mysqli_stmt_get_result($stmt);
        $exists = $result && mysqli_num_rows($result) > 0;
        close_statement($stmt);
        if ($exists) return true;
    }
    return false;
}

function getPendingAccounts() {
    global $conn;
    return mysqli_query($conn, "SELECT id, user_id, account_type FROM accounts WHERE status = 'pending' ORDER BY id");
}

function approveRejectAccount($account_id, $status) {
    if (!in_array($status, ['approved', 'rejected'], true)) return false;
    $stmt = execute_prepared('UPDATE accounts SET status = ? WHERE id = ?', 'si', [$status, $account_id]);
    if (!$stmt) return false;
    close_statement($stmt);
    return true;
}

function getLoanApplications() {
    global $conn;
    return mysqli_query($conn, "SELECT * FROM loans WHERE status = 'under_review' ORDER BY id");
}

function applyLoan($user_id, $loan_type, $amount, $duration) {
    $stmt = execute_prepared(
        "INSERT INTO loans (user_id, loan_type, amount, duration, status) VALUES (?, ?, ?, ?, 'under_review')",
        'isdi',
        [$user_id, $loan_type, $amount, $duration]
    );
    if (!$stmt) return false;
    close_statement($stmt);
    return true;
}

function verifyLoan($loan_id, $verified) {
    $stmt = execute_prepared('UPDATE loans SET verified = ? WHERE id = ?', 'ii', [(int) (bool) $verified, $loan_id]);
    if (!$stmt) return false;
    close_statement($stmt);
    return true;
}

function approveRejectLoan($loan_id, $status) {
    if (!in_array($status, ['approved', 'rejected'], true)) return false;
    $stmt = execute_prepared('UPDATE loans SET status = ? WHERE id = ?', 'si', [$status, $loan_id]);
    if (!$stmt) return false;
    close_statement($stmt);
    return true;
}

function getPendingFixedDeposits() {
    global $conn;
    return mysqli_query($conn, "SELECT id, status WHERE status = 'pending' ORDER BY id");
}

function manageFD($fd_id, $action) {
    if (!in_array($action, ['approved', 'rejected'], true)) return false;
    $stmt = execute_prepared('UPDATE fixed_deposits SET status = ? WHERE id = ?', 'si', [$action, $fd_id]);
    if (!$stmt) return false;
    close_statement($stmt);
    return true;
}

function closeAccount($account_id, $user_id) {
    $stmt = execute_prepared("UPDATE accounts SET status = 'closed' WHERE id = ? AND user_id = ? AND status IN ('pending', 'approved')", 'ii', [$account_id, $user_id]);
    if (!$stmt) return false;
    $changed = mysqli_stmt_affected_rows($stmt) === 1;
    close_statement($stmt);
    return $changed;
}

function getCustomerHistory($customer_id) {
    $data = [];
    foreach ([
        'accounts' => 'SELECT * FROM accounts WHERE user_id = ?',
        'transactions' => 'SELECT * FROM transactions WHERE user_id = ?',
        'loans' => 'SELECT * FROM loans WHERE user_id = ?'
    ] as $key => $sql) {
        $stmt = execute_prepared($sql, 'i', [$customer_id]);
        $data[$key] = $stmt ? mysqli_stmt_get_result($stmt) : false;
        close_statement($stmt);
    }
    return $data;
}

function getCustomerAccounts($customer_id) {
    $stmt = execute_prepared('SELECT id, account_type, status FROM accounts WHERE user_id = ? ORDER BY id', 'i', [$customer_id]);
    if (!$stmt) return false;
    $result = mysqli_stmt_get_result($stmt);
    close_statement($stmt);
    return $result;
}

function setTransactionLimit($account_id, $limit) {
    $stmt = execute_prepared('UPDATE accounts SET transaction_limit = ? WHERE id = ?', 'di', [$limit, $account_id]);
    if (!$stmt) return false;
    close_statement($stmt);
    return true;
}

function lockDebitCard($account_id, $status) {
    $stmt = execute_prepared('UPDATE accounts SET card_locked = ? WHERE id = ?', 'ii', [(int) (bool) $status, $account_id]);
    if (!$stmt) return false;
    close_statement($stmt);
    return true;
}

function openAccount($user_id, $account_type, $initial_deposit) {
    $stmt = execute_prepared("INSERT INTO accounts (user_id, account_type, balance, status) VALUES (?, ?, ?, 'pending')", 'isd', [$user_id, $account_type, $initial_deposit]);
    if (!$stmt) return false;
    close_statement($stmt);
    return true;
}

function close_connection() {
    global $conn;
    if ($conn instanceof mysqli) mysqli_close($conn);
}
?>