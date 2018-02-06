<?php
session_start();
if(!isset($_SESSION['login_user'])) {
   header("Location:login.php");
}

function connect() {
  try {
    $server = "127.0.0.1";
    $dbname = "PetDB";
    $username = "db_user";
    $password = "password";
    $table = "pet_table";
    $field = "pet_id";

    $connection = new PDO("mysql:host=$server,dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "SELECT " . $field . " FROM " . $table;
    $readstatement = $connection->prepare($query);
    $readstatement->execute();
    $result = $readstatement->fetchAll(PDO::FETCH_ASSOC);
  }
  catch (PDOException $p) {
    echo "Error connecting to database. " . $p->getMessage();
  }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <link rel='stylesheet' href='main.css' type='text/css' />
    <link rel='stylesheet' href='view.css' type='text/css' />
    <title>Edit Rescue</title>
  </head>
  <body>
    <?php require("connect.php"); ?>
    <?php include("footer.php"); ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="">
      <label class="label" id="pick-rescue">Pick Rescue ID</label>
      <?php
      ?>
      <?php connect(); ?>
      <select id="s01">
        <?php foreach($names as $name): ?>
          <option value="<?=$user['pet_id']; ?>"><?= $user['pet_id']; ?></option>
        <?php endforeach; ?>
      </select>
      <div class="labels" id="name-label">Name</div>
      <input type="text" id="name-field">
      <div class="labels" id="age-label">Age</div>
      <input type="text" id="age-field">
      <!-- <div class="labels" id="species-label">Species</div> -->
      <select id="s02">
      </select>
      <!-- <div class="labels" id="breed-label">Breed</div> -->
      <!-- <select id="s03"> -->
      <!-- </select> -->
      <div class="labels" id="history-label">History</div>
      <input type="text" id="history-field">
      <div class="labels" id="photo-label">Photo</div>
      <div class="photo-frame" id="photo-field"></div>
      <div class="labels" id="rescuedate-label">Rescue Date</div>
      <input type="text" id="rescuedate-field">
      <div class="labels" id="adoptiondate-label">Adoption Date</div>
      <input type="text" id="adoptiondate-field">
      <input type="submit" value="Confirm Changes" class="list-button" id="confirm-adopt">
      <input type="submit" value="Cancel" class="list-button" id="cancel-button" formaction="adoptionlist.php">
    </form>
  </body>
</html>
