<?php
session_start();
$error = '';
$connection = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
      $error = "Username or Password invalid.";
    }
    else {
      $username = $_POST['username'];
      $password = $_POST['password'];
      try {
        $hostname = "localhost";
        $dbname = "PetDB";
        $dbusername = "db_user";
        $dbpassword = "password";
        $errormessage = "Error connecting to database.";
        $table = "user_table";
        $field1 = "user_name";
        $field2 = "user_password";
        $connection = "";
        $connection = new PDO("mysql:host=$hostname; dbname=$dbname", $dbusername, $dbpassword);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // table fields for our query
        $username = stripslashes($username);
        //$username = mysql_real_escape_string($username);
        $password = stripslashes($password);
        //$password = mysql_real_escape_string($password);

        // custom BCRYPT parameter for password validation
        $option = [ 'cost' => 12, ];
        $hashpassword = password_hash($password, PASSWORD_BCRYPT, $option);

        $verifyquery = $connection->prepare("SELECT user_name, user_password FROM " . $table . " WHERE " . $field1 . " = '" . $username . "'");
        $verifyquery->execute();
        $row = '';
        $row = $verifyquery->fetch(PDO::FETCH_ASSOC);
        $hashedpassword = $row['user_password'];

        if(password_verify($password, $row['user_password'])) {
          // initialize the session
          echo "Password is valid!";
          $_SESSION['login_user'] = $username;
          $_SESSION['password'] = $password;
          header("Location: admin.php");
          $connection = null;
        } else {
          $error = "Username or password invalid.";
        }
      }
      catch (PDOException $p)
      {
        echo $errormessage . $p->getMessage();
        die();
      }
      $connection = null;
    }
  }
}

?>

<html>
  <head>
    <title>Login Portal</title>
    <link rel="stylesheet" href="main.css">
  </head>

  <body>
    <?php //include("menubar.php"); ?>
    <?php include("footer.php"); ?>
    <div id="back-button" class="dropdown">
      <span>Back</span>
      <div class="dropdown-content">
        <a href="index.php">Back to Main</a>
      </div>
    </div>

    <p class="credentials">SYSTEM ACCESS</p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="credentials">
      <label id="username-label">Username:</label>
      <input type="text" name="username" id="field1" placeholder="Username">
      <label id="password-label">Password:</label>
      <input type="password" name="password" id="field2" placeholder="********">
      <input type="submit" value="Submit" id="submit-button"/>
      <span class="error" id="login-error">
        <?php echo $error; ?>
        <?php // echo "Hashed Password: " . displayhashpassword(); ?>
      </span>
    </form>
  </body>
</html>
