<?php

session_start();
if(!isset($_SESSION['login_user'])) {
   header("Location:login.php");
}

$page = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['previous'])) {
    $page = $page - 1;
    if ($page <= 0) {
      $page = 1;
    }
  } else if (isset($_POST['next'])) {
    $page = $page + 1;
  }
  refresh_view($page);
}

function refresh_view($page = 1, $step = 3) {
  try {
    $server = "localhost";
    $dbname = "PetDB";
    $username = "db_user";
    $password = "password";
    $table = "pet_table";

    $connection = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $displayquery = "SELECT * FROM " . $table;

    $readstatement = $connection->prepare($displayquery);
    $readstatement->execute();

    $firstrecord = $step * ($page - 1);
    $lastrecord = $step * $page;

    echo "<table class=\"adoption\" id=\"pets\">";
      echo "<tbody>";
        echo "<tr>";
          echo "<th>Pet ID</th>";
          echo "<th>Name</th>";
          echo "<th>Age</th>";
          echo "<th>Species</th>";
          echo "<th>Breed</th>";
          echo "<th>History</th>";
          echo "<th>Photo</th>";
          echo "<th>Rescue Date</th>";
          echo "<th>Adoption Date</th>";
        echo "</tr>";

        echo "<tr>";
        while ($row = $readstatement->fetch(PDO::FETCH_ASSOC)) {
          $id = $row['pet_id'];
          $name = $row['pet_name'];
          $age = $row['pet_age'];
          $species = $row['pet_species'];
          $breed = $row['pet_breed'];
          $history = $row['pet_history'];
          $photo = $row['pet_photo'];
          $rescuedate = $row['rescuedate'];
          $adoptiondate = $row['adoptiondate'];
          echo "<td>";
          echo $id;
          echo "</td>";

          echo "<td>";
          echo $name;
          echo "</td>";

          echo "<td>";
          echo $age;
          echo "</td>";

          echo "<td>";
          echo $species;
          echo "</td>";

          echo "<td>";
          echo $breed;
          echo "</td>";

          echo "<td>";
          echo $history;
          echo "</td>";

          echo "<td id=\"photo-table\">";
          echo $photo;
          echo "</td>";

          echo "<td>";
          echo $rescuedate;
          echo "</td>";

          echo "<td>";
          echo $adoptiondate;
          echo "</td>";

        echo "</tr>";
      }
      echo "</tbody>";
    echo "</table>";
  }
  catch (PDOException $p) {
    echo "Error connecting to database. " . $p->getMessage();
    die();
  }
  $connection = null;
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Adoption List</title>
  <link rel='stylesheet' href='main.css' type='text/css' />
  <link rel='stylesheet' href='view.css' type='text/css' />
</head>

<body>

  <?php include('footer.php'); ?>
  <div id="back-button" class="dropdown">
    <span>Back</span>
    <div class="dropdown-content">
      <a href="admin.php">Back to Admin Panel</a>
    </div>
  </div>
  <?php refresh_view(); ?>
  <form method="post">
    <input type="submit" name="next" class="list-button" id="next-page-button" value="Next" />
    <input type="submit" name="previous" class="list-button" id="previous-page-button" value="Previous" />
    <input type="submit" name="add" class="list-button" id="add-cat-button" value="Add Cat Rescue" formaction="addrescue-cat.php" />
    <input type="submit" name="add" class="list-button" id="add-dog-button" value="Add Dog Rescue" formaction="addrescue-dog.php" />
    <input type="submit" name="edit" class="list-button" id="edit-button" value="Edit Rescue" formaction="editrescue.php" />
    <input type="submit" name="leave" class="list-button" id="leave-button" formaction="admin.php" value="Back to Admin Panel" />
  </form>
</body>
</html>
