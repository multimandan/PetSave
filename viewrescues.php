<?php

session_start();
if(!isset($_SESSION['username'])) {
   header("Location:login.php")
}
$servername = "localhost";
$username = "db_user";
$password = "password";
$dbname = "PetDB";
$table = "pet_list";

try {
  $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // SELECT query for pets up for adoption
  $selectstatement1 = $connection->prepare("SELECT pet_id, pet_name, pet_age, pet_species, pet_breed, pet_status, rescuedate, adoptiondate FROM " . $table . " WHERE pet_status = 'FALSE'");

  // SELECT query for pets already adopted
  $selectstatement2 = $connection->prepare("SELECT pet_id, pet_name, pet_age, pet_species, pet_breed, pet_status, rescuedate, adoptiondate FROM " . $table . " WHERE pet_status = 'TRUE'");
}

catch (PDOException $p) {
  echo "Error: " . $p->getMessage();
}



?>

<html>
  <head>
    <title>
      View Adopted Animals
    </title>
  </head>
  <body>
    <table>
      <tbody>
        <td>
          <th>Name</th>
          <th>Age</th>
          <th>Species</th>
          <th>Breed</th>
          <th>Description</th>
          <th>Photo</th>
          <th>Rescue Date</th>
        </td>
        <?php ?>
      </tbody>
    </table>
  </body>
</html>
