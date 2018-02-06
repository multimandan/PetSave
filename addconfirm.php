<?php
session_start();
if(!isset($_SESSION['login_user'])) {
   header("Location:login.php");
}

//if (isset($_SESSION['data']) || isset($_FILES['photoToUpload'])) {
//if (isset($_SESSION[])) {
//$name = $age = $species = $breed = $history = $photo = $rescuedate = '';
  if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
  }
  if (isset($_SESSION['age'])) {
    $age = $_SESSION['age'];
  }
  if (isset($_SESSION['species'])) {
    $species = $_SESSION['species'];
  }
  if (isset($_SESSION['breed'])) {
    $breed = $_SESSION['breed'];
  }
  if (isset($_SESSION['history'])) {
    $history = $_SESSION['history'];
  }
  if (isset($_FILES['photoToUpload'])) {
    $photo = $_FILES['photoToUpload'];
  }
  if (isset($_SESSION['rescuedate'])) {
    $rescuedate = $_SESSION['rescuedate'];
  }
//}

try {
  $servername = "localhost";
  $username = "db_user";
  $password = "password";
  $dbname = "PetDB";
  $table = "pet_table";

  $connection = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $insertquery = "INSERT INTO " . $table . " (pet_name, pet_age, pet_species, pet_breed, pet_history, pet_photo, rescuedate) VALUES (:pet_name, :pet_age, :pet_species, :pet_breed, :pet_history, :pet_photo, :rescuedate)";

  $insertstatement = $connection->prepare($insertquery);
  $insertstatement->bindParam(':pet_name', $name);
  $insertstatement->bindParam(':pet_age', $age);
  $insertstatement->bindParam(':pet_species', $species);
  $insertstatement->bindParam(':pet_breed', $breed);
  $insertstatement->bindParam(':pet_history', $history);
  $insertstatement->bindParam(':pet_photo', $photo);
  $insertstatement->bindParam(':rescuedate', $rescuedate);

  $insertstatement->execute();
}
catch (PDOException $p) {
  echo "Error connecting to database. " . $p->getMessage();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel='stylesheet' href='main.css' type='text/css' />
    <link rel='stylesheet' href='view.css' type='text/css' />
    <title>Addition Confirmed</title>
  </head>
  <body>
    <?php require("connect.php"); ?>
    <?php include("footer.php"); ?>
    <div id="back-button" class="dropdown">
      <span>Back</span>
      <div class="dropdown-content">
        <a href="adoptionlist.php">Back to Adoption List</a>
      </div>
    </div>
    <div class="acknowledgment" id="ack">
      Rescue has been added! Thank you!
    </div>
</body>
</html>
