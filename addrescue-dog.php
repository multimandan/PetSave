<?php
session_start();
if(!isset($_SESSION['login_user'])) {
   header("Location:login.php");
}

//$name = $age = $history = $rescuedate = $photoToUpload = '';
$name = $age = $history = $rescuedate = '';
//$nameErr = $ageErr = $historyErr = $rescuedateErr = $photoErr = '';
$nameErr = $ageErr = $historyErr = $rescuedateErr = '';
$destination_url = '';
//$photoFileName = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['name'])) {
      $nameErr = 'Name is required';
    } else {
      $name = test_input($_POST['name']);
    }

    if (empty($_POST['age'])) {
      $ageErr = 'Age is required';
    } else {
      $age = test_input($_POST['age']);
      if (!preg_match("/^[0-9]{1,2}$/", $_POST['age'])) {
        $ageErr = 'Age can only be numbers';
      }
    }

    if (empty($_POST['history'])) {
      $historyErr = 'History is required';
    } else {
      $history = test_input($_POST['history']);
    }

    if (empty($_POST['rescuedate'])) {
      $rescuedateErr = 'Rescue Date is required (YYYY-MM-DD)';
    } else if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_POST['rescuedate'])) {
      $rescuedateErr = 'Rescue date must be in YYYY-MM-DD format';
    } else {
      $rescuedate = test_input($_POST['rescuedate']);
    }

    if (($nameErr == '') && ($ageErr == '') && ($historyErr == '') && ($rescuedateErr == '')) {
      echo "---->UNIT TEST - inside error detection";
      $destination_url = 'addconfirm.php';
      $species = "Dog";
      $_SESSION['name'] = $name;
      $_SESSION['age'] = $age;
      $_SESSION['species'] = $species;
      //$_SESSION['breed'] = $breed;
      $_SESSION['history'] = $history;
      $_SESSION['rescuedate'] = $rescuedate;
      sleep(1);
      header("Location: $destination_url");
      exit();
    }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

    /*if (isset($_FILES['file'])) {
      $allowedExts = array("gif", "jpeg", "jpg", "png");
      $temp = explode(".", $_FILES["file"]["name"]);
      $extension = end($temp);
      if ((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/x-png")
        || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 512000)
        && in_array($extension, $allowedExts)) {
          if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
            } else {
              echo "Upload: " . $_FILES["file"]["name"] . "<br>";
              echo "Type: " . $_FILES["file"]["type"] . "<br>";
              echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
              echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
              if (file_exists("images/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " already exists. ";
              } else {
                move_uploaded_file($_FILES["file"]["tmp_name"],
                "images/" . $_FILES["file"]["name"]);
                echo "Stored in: " . "images/" . $_FILES["file"]["name"];
          }
        }
      } else {
        $photoErr = "Invalid file";
      }*/
      //if (($nameErr = '') && ($ageErr = '') && ($historyErr = '') && ($rescueErr = '') && ($photoErr = '')) {
    //} //else {
  //$photoErr = '';
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel='stylesheet' href='main.css' type='text/css' />
    <link rel='stylesheet' href='view.css' type='text/css' />
    <title>Add Dog Rescue</title>
  </head>
  <body>
    <?php require("connect.php"); ?>
    <?php include("footer.php"); ?>
<!--<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">-->
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

  <div class="labels" id="name-label">Name</div>
  <input type="text" name="name" id="name-field">

  <div class="labels" id="age-label">Age</div>
  <input type="text" name="age" id="age-field">

  <div class="labels" id="history-label">History</div>
  <textarea rows="4" cols="22" name="history" id="history-field"></textarea>
  <!-- <input type="textarea" name="history" id="history-field"> -->

  <div class="labels" id="rescuedate-label">Rescue Date</div>
  <input type="text" name="rescuedate" id="rescuedate-field">

  <input name="submit" type="submit" value="Add Rescue" class="list-button" id="confirm-adopt" />

  <!-- <input type="hidden" name="data" value=""/> -->
  <input type="button" value="Cancel" class="list-button" id="cancel-button" formaction="adoptionlist.php">

  <span class="error" id="name-error"><?php echo $nameErr; ?></span>
  <span class="error" id="age-error"><?php echo $ageErr; ?></span>
  <span class="error" id="history-error"><?php echo $historyErr; ?></span>
  <span class="error" id="rescuedate-error"><?php echo $rescuedateErr; ?></span>

<!--<div class="label" id="photo-label">Photo</div>-->
<!-- <form name="photo" action="<?php // echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" --> <!-- enctype="multipart/form-data"> -->
  <!-- <input type="file" name="file" id="photo-field"/> -->
  <!-- <input type="submit" name="submit" value="Upload" id="upload-button"/> -->
  <!-- <input type="hidden" name="photoToUpload" value=""/> -->
  <!-- <span class="ack" id="photo-upload"> -->
    <?php
      //$photoFileName = $photoFileName . " uploaded.";
      //echo $photoFileName;
    ?>
  <!--</span> -->
  <!--<span class="error" id="photo-error"><?php echo $photoErr; ?></span> -->
<!-- </form> -->
</form>

</body>
</html>
