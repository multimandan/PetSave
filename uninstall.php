<?php

$message1 = "uninstall.php -- this script drops all existing tables -- for testing purposes only\n\n";
$message2 = "Dropping tables...\n\n";

$servername = "localhost";
$dbname = "PetDB";
$username = "db_user";
$password = "password";

echo $message1;

try {
  echo $message2;
  $table = array(
    1 => "catbreed_list",
    2 => "comment_table",
    3 => "dogbreed_list",
    4 => "donation_table",
    5 => "donation_types_list",
    6 => "pet_table",
    7 => "species_list",
    8 => "user_table"
  );

  $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $dropstatement1 = $connection->prepare("DROP TABLE IF EXISTS " . $table[1]);
  $dropstatement2 = $connection->prepare("DROP TABLE IF EXISTS " . $table[2]);
  $dropstatement3 = $connection->prepare("DROP TABLE IF EXISTS " . $table[3]);
  $dropstatement4 = $connection->prepare("DROP TABLE IF EXISTS " . $table[4]);
  $dropstatement5 = $connection->prepare("DROP TABLE IF EXISTS " . $table[5]);
  $dropstatement6 = $connection->prepare("DROP TABLE IF EXISTS " . $table[6]);
  $dropstatement7 = $connection->prepare("DROP TABLE IF EXISTS " . $table[7]);
  $dropstatement8 = $connection->prepare("DROP TABLE IF EXISTS " . $table[8]);

  echo "Dropping table " . $table[1] . "\n";
  $dropstatement1->execute();
  echo "Table " . $table[1] . " dropped.\n\n";

  echo "Dropping table " . $table[2] . "\n";
  $dropstatement2->execute();
  echo "Table " . $table[2] . " dropped.\n\n";

  echo "Dropping table " . $table[3] . "\n";
  $dropstatement3->execute();
  echo "Table " . $table[3] . " dropped.\n\n";

  echo "Dropping table " . $table[4] . "\n";
  $dropstatement4->execute();
  echo "Table " . $table[4] . " dropped.\n\n";

  echo "Dropping table " . $table[5] . "\n";
  $dropstatement5->execute();
  echo "Table " . $table[5] . " dropped.\n\n";

  echo "Dropping table " . $table[6] . "\n";
  $dropstatement6->execute();
  echo "Table " . $table[6] . " dropped.\n\n";

  echo "Dropping table " . $table[7] . "\n";
  $dropstatement7->execute();
  echo "Table " . $table[7] . " dropped.\n\n";

  echo "Dropping table " . $table[8] . "\n";
  $dropstatement8->execute();
  echo "Table " . $table[8] . " dropped.\n\n";
}

catch (PDOException $p)
{
  echo 'Cannot drop tables.' . $p->getMessage();
}

?>
