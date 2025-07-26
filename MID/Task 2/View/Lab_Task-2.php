<!DOCTYPE html>
<html>
<style>
    .container {
        width: 90%;
        margin: auto;
        padding: 20px;
        border:1px solid;
        position: relative;
        z-index: 1;
    }
    div{
        width: 200px;
        height: 55px;
        border: 1px solid;
        overflow: auto
    }
</style>
<body>
    <center>
        <h1 style="color:blue"> Bank Management System</h1>
        <h2 style="color:blue"> Your trusted Financial partner</h2>
    </center>
<h3 align = "left">Customer Registration Form </h3>
<form>
    <table>
        <tr>
           <td> 
            Full Name:
            </td>
            <td> 
            <input type = "text">
            </td> 
        </tr>
         <tr>
            <td>
                Date of Birth:
            </td>
            <td>
                <input type = 'text'>
            </td>
        </tr>
        <tr>
            <td>
                Gender: 
            </td>
            <td>
                <input type = 'radio' name="des">male
                <input type = 'radio' name="des">female
                <input type = 'radio' name="des">other
            </td>
        </tr>
        <tr>
            <td>
                Marital Status :
            </td>
            <td>
            <select>
                <option value="">Single</option>
                <option value="">Married</option>
            </select>
            </td>
        </tr>
        <tr>
            <td>
                Account Type :
            </td>
            <td>
            <select>
                <option value="">Saving</option>
                <option value="">Deposit</option>
            </select>
            </td>
        </tr>
        <tr>
           <td> 
            Initial Deposit Amount:
            </td>
            <td> 
            <input type = "text">
            </td> 
        </tr>
        <tr>
           <td> 
            Mobile Number:
            </td>
            <td> 
            <input type = "text">
            </td> 
        </tr>
        <tr>
           <td> 
            Email Address:
            </td>
            <td>
            <input type = "text">
            </td> 
        </tr>
        <tr>
           <td> 
            Address:
            </td>
            <td>
            <input type = "text">
            </td> 
        </tr>
        <tr>
            <td>
                Occupation: 
            </td>
            <td>
                <input type = "text">
            </td>
        </tr>
        <tr>
            <td>
                National ID (NID): 
            </td>
            <td>
                <input type = "text">
            </td>
        </tr>  
        <tr>
            <td>
                Set Password: 
            </td>
            <td>
                <input type = "password">
            </td>
        </tr>
        <tr>
            <td>
                Upload ID Proof:
            </td>
            <td>
                <input type = 'file'>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type = 'checkbox'>I agree to the terms and conditions
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" value="Register">
                <input type = "reset" value ="Clear">
            </td>
        </tr>
    </table>
</form> 
<div>
    This is a demo text to show how overflow works in a small container with a fixed height and width. More contents can be seen by scrolling.
</div>  
</body>