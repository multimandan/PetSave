<?php
session_start();
if(!isset($_SESSION['login_user'])) {
   header("Location: login.php");
}

//require('connect.php');

try {
  $hostname = "localhost";
  $dbname = "PetDB";
  $username = "db_user";
  $password = "password";
  $errormessage = "Error connecting to database. ";
  $connection = new PDO("mysql:host=$hostname; dbname=$dbname", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $table = "donation_table";
  $index = "";
  $query = "";

  $firstrecord = '';
  $lastrecord = '';

  //$query = "SELECT * FROM " . $table . " ORDER BY " . $index . " DESC LIMIT " . '1' . ", " . '17';
  $query = "SELECT * FROM " . $table;

  $readstatement = $connection->prepare($query);
  $readstatement->execute();

  while($row = $readstatement->fetch(PDO::FETCH_ASSOC)) {
    $donation_id = $row['donation_id'];
    $donation_transaction = $row['donation_transaction'];
    $donation_amount = $row['donation_amount'];
    $donation_donor = $row['donation_donor'];
    $donation_date = $row['donation_date'];
    $donation_type = $row['donation_type'];
    $donation_notrecognized = $row['donation_notrecognized'];

    echo "<tr>";
    echo "<td id=\"comment-row\">";
    echo "<td>";
    echo "$donation_id";
    echo "</td>";
    echo "<td>";
    echo "$donation_transaction";
    echo "</td>";
    echo "<td>";
    echo "$donation_amount";
    echo "</td>";
    echo "<td>";
    echo "$donation_donor";
    echo "</td>";
    echo "<td>";
    echo "$donation_date";
    echo "</td>";
    echo "<td>";
    echo "$donation_type";
    echo "</td>";
    echo "<td>";
    echo "$donation_notrecognized";
    echo "</td>";
    echo "</tr>";
  }
}
catch (PDOException $p)
{
  echo $errormessage . $p->getMessage();
}


?>

<!DOCTYPE html>
<html>
<head>
  <link rel='stylesheet' href='main.css' type='text/css' />
  <link rel='stylesheet' href='view.css' type='text/css' />
  <title>View Donations</title>
</head>
<body>
  <?php include("footer.php"); ?>
  <div id="back-button" class="dropdown">
    <span>Back</span>
    <div class="dropdown-content">
      <a href="admin.php">Back to Admin Panel</a>
    </div>
  </div>
  <table id="donation-table">
    <tbody>
      <tr>
        <th>ID</th>
        <th>Transaction</th>
        <th>Amount</th>
        <th>Donor</th>
        <th>Date</th>
        <th>Type</th>
        <th>Recognized</th>
      </tr>
    </tbody>
  </table>
</body>
</html>
