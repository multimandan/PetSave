<!DOCTYPE HTML>

<HTML>

<HEAD>
<TITLE>Thank you!</TITLE>
<LINK REL="stylesheet" HREF="main.css"/>
</HEAD>


<div class="acknowledgment" id="ack">
  Thank you! Your comment has been submitted and our staff will read it shortly. Expect a message or a call back soon.
  <a class="button" id="goback" href="index.php">
    <br><br>-Go back to Main Site-
  </a>
</div>

</HTML>

<?php
include("footer.php");
include("menubar.php");
session_start();

$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$phone = $_SESSION['phone'];
$email = $_SESSION['email'];
$comments = $_SESSION['comments'];

try {
  // Pulling values from values submitted in the contact form

  $servername = "localhost";
  $username = "db_user";
  $password = "password";
  $dbname = "PetDB";
  $table = "comment_table";

  $connection = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create INSERT query to add the submitted comment
  $insertstatement = $connection->prepare("INSERT INTO " . $table . " (comment_first_name, comment_last_name, comment_phone, comment_email, comment_text) VALUES (:comment_first_name, :comment_last_name, :comment_phone, :comment_email, :comment_text)");

  $insertstatement->bindParam(':comment_first_name', $firstname);
  $insertstatement->bindParam(':comment_last_name', $lastname);
  $insertstatement->bindParam(':comment_phone', $phone);
  $insertstatement->bindParam(':comment_email', $email);
  $insertstatement->bindParam(':comment_text', $comments);

  $insertstatement->execute();
}

catch (PDOException $p) {
  echo "Error creating database connection. Please make sure MySQL service is running." . $p->getMessage();
}
?>
