<?php
session_start();
include "../db/db.php"; 

$fnameError = $emailError = $usernameError = $passwordError = $confirmPasswordError = $phoneError = $genderError = $accountTypeError = $nidError = $departmentError = "";

$fname = $email = $username = $password = $confirm_password = $phone = $gender = $address = $account_type = $nid = $department = "";

$isValid = true;

if (isset($_POST["Register"])) 
    {

        $role = $_POST["role"] ?? "";
        if ($role !== "customer" && $role !== "employee") 
            {
            die("Invalid role selected.");
            }

    if (empty($_POST["fname"])) 
        {
            $fnameError = "Full name required";
            $isValid = false;
        } 
    else 
        {
            $fname = test_input($_POST["fname"]);
            if (!preg_match("/^[A-Z][a-z ]+$/", $fname)) 
                {
                     $fnameError = "Name must start with capital letter and only contain letters/spaces";
                     $isValid = false;
                }
    }

    if (empty($_POST["email"])) 
        {
            $emailError = "Email required";
            $isValid = false;
        } 
        else 
            {
                $email = test_input($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
                    {
                        $emailError = "Invalid email format";
                        $isValid = false;
                    }
            }

    if (empty($_POST["uname"])) 
        {
            $usernameError = "Username required";
            $isValid = false;
        } 
    else 
        {
            $username = test_input($_POST["uname"]);
            if (!preg_match("/^[a-z0-9]{3,}$/", $username)) 
                { // lowercase letters & numbers
                    $usernameError = "Username must be lowercase letters/numbers, min 3 characters";
                    $isValid = false;
                }
        }

    if (empty($_POST["password"])) 
        {
            $passwordError = "Password required";
            $isValid = false;
        } 
    elseif (strlen($_POST["password"]) < 4) 
        {
            $passwordError = "Password must be at least 4 characters";
            $isValid = false;
        } 
        else 
            {
                $password = $_POST["password"];
            }

    if (empty($_POST["cpassword"])) 
        {
            $confirmPasswordError = "Confirm Password required";
            $isValid = false;
        } 
        elseif ($_POST["cpassword"] != $_POST["password"]) 
        {
            $confirmPasswordError = "Passwords do not match";
            $isValid = false;
    } 
    else 
        {
        $confirm_password = $_POST["cpassword"];
        }

    if (empty($_POST["phone"])) 
        {
        $phoneError = "Phone required";
        $isValid = false;
        } 
        else 
            {
                $phone = test_input($_POST["phone"]);
            }

    if (empty($_POST["gender"])) 
        {
            $genderError = "Gender required";
            $isValid = false;
        } 
    else 
        {
            $gender = $_POST["gender"];
        }

    if ($role === "customer") 
        {
            $address = test_input($_POST["address"] ?? "");
        if (empty($_POST["account_type"])) 
            {
                $accountTypeError = "Account type required";
                $isValid = false;
        } 
        else 
            {
                $account_type = $_POST["account_type"];
            }
        if (empty($_POST["nid"])) 
            {
                $nidError = "NID required";
                $isValid = false;
        } 
        else 
            {
                $nid = test_input($_POST["nid"]);
            }
    }

    if ($role === "employee") 
        {
            if (empty($_POST["department"])) 
                {
                    $departmentError = "Department required";
                    $isValid = false;
        } 
        else 
            {
                $department = test_input($_POST["department"]);
            }
        }

    if ($isValid) 
        {
        // Duplicate username check
        $checkSql = "SELECT * FROM customer WHERE uname = '$username'";
        if ($role === "employee") 
            {
                $checkSql = "SELECT * FROM employee WHERE uname = '$username'";
            }
        $checkResult = mysqli_query($conn, $checkSql);
        if (mysqli_num_rows($checkResult) > 0) 
            {
                $usernameError = "Username already taken. Choose another";
                closeConn($conn);
                exit();
        } 
        else 
            {
                if ($role === "customer") 
                    {
                        $sql = "INSERT INTO customer (fname, uname, email, password, phone, gender, address, account_type, nid)
                        VALUES ('$fname', '$username', '$email', '$password', '$phone', '$gender', '$address', '$account_type', '$nid')";
                    } 
                    elseif ($role === "employee") 
                        {
                            $sql = "INSERT INTO employee (fname, uname, email, password, phone, gender, department)
                            VALUES ('$fname', '$username', '$email', '$password', '$phone', '$gender', '$department')";
                        }

                if (mysqli_query($conn, $sql)) 
                    {
                        close_connection();
                        header("Location: ../view/login.php");
                    exit();
            } 
            else 
                {
                    echo "<p style='color:red;'>Database error: " . mysqli_error($conn) . "</p>";
                    close_connection();
                }
        }
    }
}


function test_input($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}
?>
