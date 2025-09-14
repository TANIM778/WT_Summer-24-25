<?php
session_start();
include "../db/db.php";
$role = $uname = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["role"]) ||  empty($_POST["uname"]) || 
        empty($_POST["password"])) 
        {
             die(" Please fill the form completely.");
        }
    
    $role = test_input($_POST["role"]);
    $uname = test_input($_POST["uname"]);
    $password = test_input($_POST["password"]);

    global $conn; 
    $uname_safe = mysqli_real_escape_string($conn, $uname);
    $password_safe = mysqli_real_escape_string($conn, $password); 
    
     if ($role === 'customer') 
        {
        $table = 'customer';
        $uname_col = 'uname';
        $pass_col = 'password';
        $redirect_page = '../view/c_dashboard.php';
        } 
    elseif ($role === 'employee') 
    {
        $table = 'employee';
        $uname_col = 'uname';
        $pass_col = 'password';
        $redirect_page = '../view/e_dashboard.php';
    }

     $sql = "SELECT * FROM $table WHERE $uname_col='$uname_safe' AND $pass_col='$password_safe' LIMIT 1";
     $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) 
        {
             $user=mysqli_fetch_assoc($result);
             $_SESSION['role'] = $role;
             $_SESSION['uname'] = $user[$uname_col];
             $_SESSION['name'] = $user['fname'];
             header("Location: $redirect_page");
             exit;
        } 
    else 
        {
            die(" Invalid credentials. Please try again.");
        }
}

function test_input($data) 
{
    $data = trim($data);             
    $data = stripslashes($data);     
    return $data;
}
