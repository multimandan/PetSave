<?php
  $invitation = "Would you like to adopt this pet? Please use the Conctact Us</a> form in order to let us know, or send us a message to adopt@petsave.org -- or call us directly at 1-800-PET-SAVE.";

function showpets($page = 1, $step = 4) {
  try {
    $servername = "localhost";
    $dbname = "PetDB";
    $username = "db_user";
    $password = "password";
    $table = "pet_table";

    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM " . $table;

    $statement = $connection->prepare($query);
    $statement->execute();

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
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
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
}
$connection = null;
?>

<html>

<head>
<title>Pet Save</title>
<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="view.css">
</head>
  <body>
    <?php include("menubar.php"); ?>
    <?php include("footer.php"); ?>
    <div id="showpets">
      <?php showpets(); ?>
    </div>
  </body>
</html>
