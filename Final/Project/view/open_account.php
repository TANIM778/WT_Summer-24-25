<?php
session_start();

// Make sure user is logged in and is a customer
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'customer') 
    {
    header("Location: ../view/login.php");
    exit;
    }

$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';

unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['success']);
?>

<h2>Open Bank Account</h2>

<?php if ($errors): ?>
    <div style="color:red;">
        <?php foreach($errors as $err) echo $err . "<br>"; ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div style="color:green;"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="post" action="../php/open_account_valid.php">
    
    User Name: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
    <input type="hidden" name="uname" value="<?= htmlspecialchars($_SESSION['username']) ?>"><br>

    Account Type: 
    <select name="account_type" required>
        <option value="Savings" <?= (isset($old['account_type']) && $old['account_type']=='Savings')?'selected':'' ?>>Savings</option>
        <option value="Current" <?= (isset($old['account_type']) && $old['account_type']=='Current')?'selected':'' ?>>Current</option>
        <option value="Fixed Deposit" <?= (isset($old['account_type']) && $old['account_type']=='Fixed Deposit')?'selected':'' ?>>Fixed Deposit</option>
    </select><br>

    Initial Deposit: <input type="number" step="0.01" name="initial_deposit" value="<?= $old['initial_deposit'] ?? '' ?>" required><br>

    <button type="submit">Open Account</button>
</form>
