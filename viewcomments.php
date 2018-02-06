<?php

session_start();

include("footer.php");


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
  clear_view();
  refresh_view($page);
}

function clear_view() {
  header("Refresh:0");
  /*
  echo "<table id=\"comments\">";
    echo "<tbody>";
      echo "<tr>";
        echo "<th>Comment ID</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Phone</th>";
        echo "<th>E-mail</th>";
        echo "<th id=\"comment-text-header\">Text</th>";
        echo "<th id=\"comment-date-header\">Date</th>";
        echo "<th>Not Read</th>";
      echo "</tr>";
  echo "<tr id=\"comment-row\">";
  */
  /*
    $comment_id = "&nbsp;";
    $comment_first_name = "&nbsp;";
    $comment_last_name = "&nbsp;";
    $comment_phone = "&nbsp;";
    $comment_email = "&nbsp;";
    $comment_text = "&nbsp;";
    $comment_date = "&nbsp;";
    $comment_notread = "&nbsp;";
    */
    //$i = 0;
    //for ($i = 0; $i < 18; $i++) {
      /*
      echo "<td>";
      //echo "&nbsp;";
      echo "</td>";
      echo "<td>";
      //echo "&nbsp;";
      echo "</td>";
      echo "<td>";
      //echo "&nbsp;";
      echo "</td>";
      echo "<td>";
      //echo "&nbsp;";
      echo "</td>";
      echo "<td>";
      //echo "&nbsp;";
      echo "</td>";
      echo "<td id=\"comment-text\">";
      //echo "&nbsp;";
      echo "</td>";
      echo "<td>";
      //echo "&nbsp;";
      echo "</td>";
      echo "<td>";
      //echo "&nbsp;";
      echo "</td>";
      echo "</tr>";
      */
    //}

  //echo "</tbody>";
  //echo "</table>";
}

function refresh_view($page = 1, $step = 18) {
  try {
    // database variables
    $server = "localhost";
    $dbname = "PetDB";
    $username = "db_user";
    $password = "password";
    $table = "comment_table";
    $index = "comment_id";
    $connection = new PDO("mysql:host=$server;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // result set variables
    $firstrecord = $step * ($page - 1);
    $lastrecord = $step * $page;
    $finalpage = FALSE;
    $recordcount = 0;

    $query = "SELECT * FROM " . $table . " ORDER BY " . $index . " DESC LIMIT " . $firstrecord . ", " . $lastrecord;
    $readstatement = $connection->prepare($query);
    $readstatement->execute();

    echo "<table id=\"comments\">";
      echo "<tbody>";
        echo "<tr>";
          echo "<th>Comment ID</th>";
          echo "<th>First Name</th>";
          echo "<th>Last Name</th>";
          echo "<th>Phone</th>";
          echo "<th>E-mail</th>";
          echo "<th id=\"comment-text-header\">Text</th>";
          echo "<th id=\"comment-date-header\">Date</th>";
          echo "<th>Not Read</th>";
        echo "</tr>";
    echo "<tr id=\"comment-row\">";
    while ($row = $readstatement->fetch(PDO::FETCH_ASSOC)) {
      $comment_id = $row['comment_id'];
      $comment_first_name = $row['comment_first_name'];
      $comment_last_name = $row['comment_last_name'];
      $comment_phone = $row['comment_phone'];
      $comment_email = $row['comment_email'];
      $comment_text = $row['comment_text'];
      $comment_date = $row['comment_date'];
      $comment_notread = $row['comment_notread'];
      echo "<td>";
      echo $comment_id;
      echo "</td>";
      echo "<td>";
      echo $comment_first_name;
      echo "</td>";
      echo "<td>";
      echo $comment_last_name;
      echo "</td>";
      echo "<td>";
      echo $comment_phone;
      echo "</td>";
      echo "<td>";
      echo $comment_email;
      echo "</td>";
      echo "<td id=\"comment-text\">";
      echo $comment_text;
      echo "</td>";
      echo "<td>";
      echo $comment_date;
      echo "</td>";
      echo "<td>";
      echo $comment_notread;
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
  countbyindex($index, $table, $connection);
  countentries($table, $connection);
  $connection = null;
}

function countpages($entries, $step = 18) {
  $wholepages = $pages = "";
  // $wholepages = round($entries / $step);
  if ($entries % $pages == 0) {
    $pages = round($entries / $step);
  } else {
    $pages = round($entries / $step) + 1;
  }
  return $pages;
}

function countentries($table, $connection) {
  $countquery = "SELECT COUNT(*) FROM " . $table;
  $readstatement = $connection->query($countquery);
  $result = $readstatement->fetch();
  $count = $result[0];
  // this is the actual number of entries if the table is unaltered (comment_id starting at 1)
  $message = "Total of messages: " . $count . "\n";
  unset($readstatement);
  return $message;
}

function countbyindex($index, $table, $connection) {
  $totalquery = "SELECT " . $index . " FROM " . $table . " ORDER BY " . $index . " DESC";
  $readstatement = $connection->query($totalquery);
  $result = $readstatement->fetch();
  $numberofentries = $result[0];
  // if entries somehow get deleted, we should probably use this for the paging mechanism
  $message = "Last entry: " . $numberofentries . "\n";
  unset($readstatement);
  //return $message;
  return $numberofentries;
}

?>

<!DOCTYPE html>
<html>
  <head>
    <link rel='stylesheet' href='main.css' type='text/css' />
    <link rel='stylesheet' href='view.css' type='text/css' />
    <title>View Comments</title>
  </head>
  <body>
    <?php include("footer.php"); ?>
    <?php refresh_view(); ?>
    <div id="back-button" class="dropdown">
      <span>Back</span>
      <div class="dropdown-content">
        <a href="admin.php">Back to Admin Panel</a>
      </div>
    </div>
    <form method="post">
      <input type="submit" name="previous" class="list-button" id="previous-button" value="Previous" />
      <input type="submit" name="next" class="list-button" id="next-button" value="Next" />
    </form>
  </body>
</html>
