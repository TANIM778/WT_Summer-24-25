<!DOCTYPE html>
<head>
  <title>Bank Management System — Login</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <form action="../php/reg_valid.php" method="POST">
    <fieldset>
      <legend>Registration</legend>
      <table>
        <tr>
          <td><label for="role">Role:</label></td>
          <td>
            <select id="role" name="role" required onchange="toggleFields()">
              <option value="">Select your role</option>
              <option value="customer">Customer</option>
              <option value="employee">Employee</option>
            </select>
          </td>
        </tr>

        <tr>
          <td><label for="email">Email:</label></td>
          <td><input type="text" id="email" name="email" ></td>
        </tr>

        <tr>
          <td><label for="fname">Fullname:</label></td>
          <td><input type="text" id="fname" name="fname" ></td>
        </tr>

        <tr>
          <td><label for="uname">Username:</label></td>
          <td><input type="text" id="uname" name="uname" ></td>
        </tr>

        <tr>
          <td><label for="password">Password:</label></td>
          <td><input type="password" id="password" name="password" ></td>
        </tr>

        <tr>
          <td><label for="cpassword">Confirm Password:</label></td>
          <td><input type="password" id="cpassword" name="cpassword" ></td>
        </tr>

        <tr>
          <td><label for="phone">Phone:</label></td>
          <td><input type="phone" id="phone" name="phone" ></td>
        </tr>

         <tr>
          <td><label for ="Gender">Gender:</label></td>
          <td>
            <input type ="radio" id="gender" name="gender" value = 'Male' >male
            <input type ="radio" id="gender" name="gender" value = 'Female' >female
          </td>
        </tr>

        
         <!-- Customer Specific Fields -->
        <tbody id="customerFields" style="display:none;"> 
          <tr>
            <td><label for="address">Address:</label></td>
            <td><input type="text" id="address" name="address"></td>
          </tr>
          <tr>
            <td><label for="account_type">Account Type:</label></td>
            <td>
              <select id="account_type" name="account_type">
                <option value="savings">Savings</option>
                <option value="current">Current</option>
                <option value="fixed">Fixed Deposit</option>
              </select>
            </td>
          </tr>
          <tr>
            <td><label for="nid">National ID:</label></td>
            <td><input type="text" id="nid" name="nid"></td>
          </tr>
        </tbody>

        <!-- Employee Specific Fields -->
        <tbody id="employeeFields" style="display:none;"> 

          <tr>
            <td><label for="department">Department:</label></td>
            <td><input type="text" id="department" name="department"></td>
          </tr>

        </tbody>

        <tr>
          <td colspan="2" style="text-align:center;">
            <button type="submit" name = "Register">Register</button>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="text-align:center;"> 
            <a href="login.php">Already have an account? Login</a>
          </td>
        </tr>
      </table>
    </fieldset>
  </form>


  <script>
    function toggleFields() 
    { 
      let role = document.getElementById("role").value;
      let customerFields = document.getElementById("customerFields");
      let employeeFields = document.getElementById("employeeFields");

      if (role === "customer") {
        customerFields.style.display = "table-row-group";
        employeeFields.style.display = "none";
      } else if (role === "employee") {
        customerFields.style.display = "none";
        employeeFields.style.display = "table-row-group";
      } else {
        customerFields.style.display = "none";
        employeeFields.style.display = "none";
      }
    }
  </script>
</body>
</html>