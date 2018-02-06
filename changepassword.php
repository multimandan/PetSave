<?php
session_start();
// the error messages we'll need
$oldpasswordErr = $newpasswordErr = $samepasswordErr = $passwordnotmatchingErr = '';
$username = $_SESSION['login_user'];
$password = $_SESSION['password'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!isset($_POST['submit'])) {
    if (empty($_POST['oldpassword'])) {
      $oldpasswordErr = 'Old password is required';
    }
    if ($_POST['oldpassword'] != $_SESSION['password']) {
      $oldpasswordErr = 'Old password is wrong';
    }
    if ($_POST['oldpassword'] == $_POST['newpassword']) {
      $samepasswordErr = 'New password and old password cannot be the same';
    }
    if(empty($_POST['newpassword']) || empty($_POST['confirmnewpassword'])) {
      $passwordnotmatchingErr = 'New password and confirmation are required';
    }
    if ($_POST['newpassword'] != $_POST['confirmnewpassword']) {
      $passwordnotmatchingErr = 'New password and confirmation must be the same';
    }
  }
  try {
    $newpassword = $_POST['newpassword'];
    $newpassword = stripslashes($newpassword);
    $dbname = "PetDB";
    $servername = "localhost";
    $dbusername = "db_user";
    $dbpassword = "password";
    $table = "user_table";
    $field1 = "user_id";
    $field2 = "user_password";
    $connection = '';
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $confirmnewpassword = stripslashes($confirmnewpassword);
    $option = [ 'cost' => 12, ];
    $hashpassword = password_hash($newpassword, PASSWORD_BCRYPT, $option);
    $updatequery = "UPDATE user_table SET user_password = :password WHERE user_name = :username";
    $statement = $connection->prepare($updatequery);
    $statement->execute(array(':password'=>$hashpassword, ':username'=>$username));
    
    sleep(2);
    header("Location: login.php");
  }
  catch (PDOException $p) {
    echo "Error connecting to database: " . $p->getMessage();
  }
  $connection = null;
}

?>

<!DOCTYPE html>
<html>
  <head>
    <link rel='stylesheet' href='main.css' type='text/css' />
    <link rel='stylesheet' href='view.css' type='text/css' />
    <title>Change Password</title>
  </head>
  <body class="main">
    <?php include ("footer.php"); ?>
    <div id="back-button" class="dropdown">
      <span>Back</span>
      <div class="dropdown-content">
        <a href="admin.php">Back to Admin Panel</a>
      </div>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="newpassword-form">
      <div class="labels" id="firstname-label">Old Password:</div>
      <input type="password" name="oldpassword" id="oldpassword-field"><br>
      <span class="error" id="oldpassworderror"><?php echo $oldpasswordErr; ?></span>

      <div class="labels" id="lastname-label">New Password:</div>
      <input type="password" name="newpassword" id="newpassword-field"><br>
      <span class="error" id="newpassworderror"><?php echo $samepasswordErr; ?></span>

      <div class="labels" id="phone-label">Confirm New Password:</div>
      <input type="password" name="confirmnewpassword" id="confirmnew-field"><br>
      <span class="error" id="confirmpassworderror"><?php echo $passwordnotmatchingErr; ?></span>
      <input type="submit" id="submit-password-button">
    </body>
</html>
