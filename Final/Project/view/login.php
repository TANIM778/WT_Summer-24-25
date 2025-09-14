<!DOCTYPE html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bank Management System — Login</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <form action="../php/login_valid.php" method="POST">
    <fieldset>
      <legend>Login to Bank Management System</legend>
      <table>
        <tr>
          <td><label for="role">Role:</label></td>
          <td>
            <select id="role" name="role" >
              <option value="">Select your role</option>
              <option value="customer">Customer</option>
              <option value="employee">Employee</option>
            </select>
          </td>
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
          <td colspan="2" style="text-align:center;">
            <button type="submit">Login</button>
          </td>
        </tr>

        <tr>
          <td colspan="2" style="text-align:center;">
            <a href="forgot-password">Forgot Password?</a> | 
            <a href="reg.php">Register</a>
          </td>
        </tr>
      </table>
    </fieldset>
  </form>
</body>
</html>
