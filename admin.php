<?php include("footer.php");

session_start();
if(!isset($_SESSION['login_user'])) {
  header("Location:login.php");
}
//} else {
  // these booleans control the update of alert messages at the top of the pages
  $newmessages = $newdonations = NULL;
  //$newmessages = TRUE;
  //$newdonations = TRUE;

  // here we start the Admin session
  //$_SESSION['name'] = "Administrator";
  $greeting = 'Hello, ' . $_SESSION['login_user'] . ' and welcome.';

  function connect($table, $query) {
    $server = "localhost";
    $database = "PetDB";
    $username = "db_user";
    $password = "password";
    $count = "";
    $result = "";
    $statement = "";
    $newmessages = FALSE;
  $newdonations = FALSE;

  try {
    $connection = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement = $connection->query($query);

    $result = $statement->fetch();

    $count = $result[0];
    return (int)$count; // test location
  }
  catch (PDOException $p){
    Echo "Error connecting to database. " . $p->getMessage();
  }
}

function checkmessages() {
  $table = "comment_table";
  $query = "SELECT COUNT(*) FROM " . $table . " WHERE comment_notread = '1'";
  if (connect($table, $query) > 0) {
    $newmessages = TRUE;
  } else {
    $newmessages = FALSE;
  }
  if ($newmessages == FALSE) {
    $alert1 = "";
    echo $alert1;
  } else {
     $alert1 = "You have new messages.";
     echo $alert1;
  }
  return $alert1;
}

  function checkdonations() {
    $table = "donation_table";
    $query = "SELECT COUNT(*) FROM " . $table . " WHERE donation_notrecognized = '1'";
    if (connect($table, $query) > 0) {
      $newdonations = TRUE;
    } else {
      $newdonations = FALSE;
    }
    if ($newdonations == FALSE) {
      $alert2 = "";
      echo $alert2;
    } else {
      $alert2 = "You have new donations.";
      echo $alert2;
   }
  }
//}
?>

 <html>
  <head>
   <title>Pet Save</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="main.css">
  </head>
 <body>
   <div class="alert" id="message-alert">
     <?php checkmessages(); ?>
    </div>
   <div class="alert" id="donation-alert">
     <?php checkdonations(); ?>
   </div>
   <div class="alert" id="greeting-message"><?php echo $greeting; ?></div>

   <form>
     <button type="submit" class="panel-button" id="comments-button" formaction="viewcomments.php">View Comments</button>
     <button type="submit" class="panel-button" id="donations-button" formaction="viewdonations.php">View Donations</button>
     <button type="submit" class="panel-button" id="adoption-button" formaction="adoptionlist.php">Maintain Adoption List</button>
     <button type="submit" class="panel-button" id="change-button" formaction="changepassword.php">Change Password</button>
     <button type="submit" class="panel-button" id="logoff-button" formaction="logoff.php">Log Off</button>
   </form>

 </body>

 </html>
