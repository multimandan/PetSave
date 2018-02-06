
SETUP.PHP
---------

This script creates all the tables used by the program once the database
has been created.
An error will be generated if the tables already exist.
All tables are disposable except for pet_list which is the master table
that shows which pets are to be adopted, or already have been adopted.

*/

<?php

//Use PetDB;
// CREATE USER 'db_user'@'localhost' IDENTIFIED BY 'password';
// GRANT ALL PRIVILEGES ON PetDB.* to db_user@localhost;
$servername = "localhost";
$username = "db_user";
$password = "password";
$dbname = "PetDB";
/*
/* List of tables we are going to create and use
  The convention used is *_list for static (control) tables, *_table for
  dynamic tables
*/
$table = array(
  1 => "catbreed_list",
  2 => "dogbreed_list",
  3 => "pet_table",
  4 => "user_table",
  5 => "species_list",
  6 => "comment_table",
  7 => "donation_table",
  8 => "donation_types_list"
);
// our master files with the breed definitions for cats and dogs
$file1 = 'cat-breeds.txt';
$file2 = 'dog-breeds.txt';
$catfile = fopen($file1, "r") or die("Cannot find " . $file1);
$dogfile = fopen($file2, "r") or die("Cannot find " . $file2);

try {
  $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $createstatement = array (
    1 => $connection->prepare("CREATE TABLE " . $table[1] . " (catbreed_id INT NOT NULL AUTO_INCREMENT, catbreed_name VARCHAR(20) NOT NULL, PRIMARY KEY (catbreed_id))"),
    2 => $connection->prepare("CREATE TABLE " . $table[2] . " (dogbreed_id INT NOT NULL AUTO_INCREMENT, dogbreed_name VARCHAR(20) NOT NULL, PRIMARY KEY (dogbreed_id))"),
    3 => $connection->prepare("CREATE TABLE " . $table[3] . " (
    pet_id INT NOT NULL AUTO_INCREMENT,
    pet_name VARCHAR(15) NOT NULL,
    pet_age INT NOT NULL,
    pet_species VARCHAR(3) NOT NULL,
    pet_breed VARCHAR(20),
    pet_history VARCHAR(300) NOT NULL,
    pet_photo LONGBLOB,
    rescuedate DATE NOT NULL,
    adoptiondate DATE,
    PRIMARY KEY (pet_id))"),
    4 => $connection->prepare("CREATE TABLE " . $table[4] . "(
    user_id INT NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(15) NOT NULL,
    user_password VARCHAR(255) NOT NULL,
    user_expired TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (user_id))"),
    5 => $connection->prepare("CREATE TABLE " . $table[5] . "(
    species_id INT NOT NULL AUTO_INCREMENT,
    species_name VARCHAR(3) NOT NULL,
    PRIMARY KEY (species_id))"),
    6 => $connection->prepare("CREATE TABLE " . $table[6] . "(
    comment_id INT NOT NULL AUTO_INCREMENT,
    comment_first_name VARCHAR(15) NOT NULL,
    comment_last_name VARCHAR(15),
    comment_phone VARCHAR(15),
    comment_email VARCHAR(20) NOT NULL,
    comment_text VARCHAR(200) NOT NULL,
    comment_date DATETIME NOT NULL DEFAULT NOW(),
    comment_notread TINYINT(1) DEFAULT 1,
    PRIMARY KEY (comment_id))"),
    7 => $connection->prepare("CREATE TABLE " . $table[7] . "(
    donation_id INT NOT NULL AUTO_INCREMENT,
    donation_transaction VARCHAR(12) NOT NULL,
    donation_amount INT NOT NULL,
    donation_donor VARCHAR(50) NOT NULL,
    donation_date DATETIME DEFAULT NOW(),
    donation_type VARCHAR(18) NOT NULL,
    donation_notrecognized TINYINT(1) DEFAULT 1,
    PRIMARY KEY (donation_id))"),
    8 => $connection->prepare("CREATE TABLE " . $table[8] . "(
    donation_type_id INT NOT NULL AUTO_INCREMENT,
    donation_type_pmt VARCHAR(20) NOT NULL,
    PRIMARY KEY (donation_type_id))")
  );

  // Acknowledgment of tables being created
  $tablecount = sizeof($table);
  for ($i = 1; $i <= $tablecount; $i++) {
    echo "Creating table " . $table[$i] . "\n";
    $createstatement[$i]->execute();
    echo "Table " . $table[$i] . " created.\n\n";
  }

  // Insert statement for the user table (default admin user created)
  $insertstatement1 = $connection->prepare("INSERT INTO " . $table[4] . " (user_id, user_name, user_password) VALUES (:user_id, :user_name, :user_password)");
  $id = 1;
  $insertstatement1->bindParam(':user_id', $id);
  $name = 'admin';
  $insertstatement1->bindParam(':user_name', $name);
  $password = 'test1234';
  $storedpassword = generate_password($password);
  $insertstatement1->bindParam(':user_password', $storedpassword);

  // Insert statements for species control table
  $insertstatement2 = $connection->prepare("INSERT INTO " . $table[5] . "(species_id, species_name) VALUES (:species_id, :species_name)");
  $id = 1;
  $insertstatement2->bindParam(':species_id', $id);
  $species = 'cat';
  $insertstatement2->bindParam(':species_name', $species);

  $insertstatement3 = $connection->prepare("INSERT INTO " . $table[5] . "(species_id, species_name) VALUES (:species_id, :species_name)");
  unset($id);
  unset($species);
  $id = 2;
  $species = "dog";
  $insertstatement3->bindParam(':species_id', $id);
  $insertstatement3->bindParam(':species_name', $species);

  // Insert statement for control table listing types of donations
  $insertstatement4 = $connection->prepare("INSERT INTO " . $table[8] . " (donation_type_id, donation_type_pmt) VALUES (:donation_type_id, :donation_type_pmt)");
  $don_id = 1;
  $don_type = 'Credit Card';
  $insertstatement4->bindParam('donation_type_id', $don_id);
  $insertstatement4->bindParam('donation_type_pmt', $don_type);
  echo "Inserting values into table " . $table[8] . "\n";
  $insertstatement4->execute();
  echo "Values inserted into table " . $table[8] . "\n\n";

  // Insert statement for control table listing types of donations
  $insertstatement5 = $connection->prepare("INSERT INTO " . $table[8] . " (donation_type_id, donation_type_pmt) VALUES (:donation_type_id, :donation_type_pmt)");
  unset($don_id);
  unset($don_type);
  $don_id = 2;
  $don_type = 'Bank Wire Transfer';
  $insertstatement5->bindParam('donation_type_id', $don_id);
  $insertstatement5->bindParam('donation_type_pmt', $don_type);
  echo "Inserting more values into table " . $table[8] . "\n";
  $insertstatement5->execute();
  echo "Values inserted into table " . $table[8] . "\n\n";

  // Insert statement for control table listing types of donations
  $insertstatement6 = $connection->prepare("INSERT INTO " . $table[8] . " (donation_type_id, donation_type_pmt) VALUES (:donation_type_id, :donation_type_pmt)");
  unset($don_id);
  unset($don_type);
  $don_id = 3;
  $don_type = 'In-Person Pledge';
  $insertstatement6->bindParam('donation_type_id', $don_id);
  $insertstatement6->bindParam('donation_type_pmt', $don_type);
  echo "Inserting more values into table " . $table[8]. "\n";
  $insertstatement6->execute();
  echo "Values inserted into table " . $table[8] . "\n\n";

  echo "Inserting values into table " . $table[4] . "\n";
  $insertstatement1->execute();
  echo "Values inserted into table " . $table[4] . "\n\n";

  echo "Inserting values into table " . $table[5] . "\n";
  $insertstatement2->execute();
  echo "Values inserted into table " . $table[5] . "\n\n";

  echo "Inserting more values into table " . $table[5] . "\n";
  $insertstatement3->execute();
  echo "Values inserted into table " . $table[5] . "\n\n";

  // Prepared statement with INSERT query for cat breed list
  $statement1 = $connection->prepare("INSERT INTO " . $table[1] . " (catbreed_id, catbreed_name) VALUES (:catbreed_id, :catbreed_name)");
  $statement1->bindParam(':catbreed_id', $catbreed_id);
  $statement1->bindParam(':catbreed_name', $catbreed_name);
  $counter = 1;
  while(!feof($catfile)) {
    $catbreed_id = $counter;
      $catbreed_name = fgets($catfile);
      $statement1->execute();
      $counter++;
    }

  // Prepared statement that adds a "Mutt" breed at the end of the table (since it was blank)
  $value = 'Mutt';
  $update1 = $connection->prepare("UPDATE " . $table[1] . " SET catbreed_name = '" . $value . "' WHERE  catbreed_name = '' ORDER BY catbreed_id DESC LIMIT 1");
  $update1->execute();

  // Prepared statement with INSERT query for dog breed list
  $statement2 = $connection->prepare("INSERT INTO " . $table[2] . " (dogbreed_id, dogbreed_name) VALUES (:dogbreed_id, :dogbreed_name)");
  $statement2->bindParam('dogbreed_id', $dogbreed_id);
  $statement2->bindParam('dogbreed_name', $dogbreed_name);
  unset($counter);
  $counter = 1;
  while(!feof($dogfile)) {
    $dogbreed_id = $counter;
    $dogbreed_name = fgets($dogfile);
    $counter++;
    $statement2->execute();
  }
  // Prepared statement that adds a "Mutt" breed at the end of the table
  $update2 = $connection->prepare("UPDATE " . $table[2] . " SET dogbreed_name = '" . $value . "' WHERE dogbreed_name = '' ORDER BY dogbreed_id DESC LIMIT 1");
  $update2->execute();
}

catch (PDOException $pe) {
    echo "Error: " . $pe->getMessage();
}
$connection = null;

fclose($catfile);
fclose($dogfile);

function generate_password($password) {
  $options = [ 'cost' => 12, ];
  // here we use BCRYPT as the hashing algorithm and a computing cost of 12
  $generatedpassword = password_hash($password, PASSWORD_BCRYPT, $options);
  //$generatedpassword = password_hash($password, PASSWORD_DEFAULT);
  return $generatedpassword;
}
?>
