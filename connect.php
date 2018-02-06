<?php
// this should be added to a .php library or .inc file
function connectdb()
{
  try {
    $hostname = "localhost";
    $dbname = "PetDB";
    $username = "db_user";
    $password = "password";
    $errormessage = "Error connecting to database. ";
    $connection = new PDO("mysql:host=$hostname; dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch (PDOException $p)
  {
    echo $errormessage . $p->getMessage();
  }
}

function closedbconnection($connection) {
  $connection = null;
}
?>
