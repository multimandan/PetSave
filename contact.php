<!DOCTYPE html>
  <html>
  <head>
  <title>PetSave</title>
  <link rel="stylesheet" href="main.css">
  </head>
    <body>
    <?php
    include("menubar.php");
    include("footer.php");
    $firstname = $lastname = $phone = $email = $comments = '';
    $firstnameErr = $lastnameErr = $emailErr = $phoneErr = $commentsErr = '';

    error_reporting(-1);
    session_start();
    
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (empty($_POST['firstname'])) {
        $firstnameErr = "First name is required";
      } else {
        $firstname = test_input($_POST['firstname']);
        if (!preg_match("/^[a-zA-Z -]*$/", $firstname)) {
          $firstnameErr = "Only letters, hypens and white spaces allowed in the first name.";
        }
      }

      $lastname = test_input($_POST['lastname']);
      if(!empty($lastname)) {
        if(!preg_match("/^[a-zA-Z -]*$/", $lastname)) {
          $lastnameErr = "Only letters, hyphens and white spaces allowed in the last name.";
        } else {
          $lastname = test_input($_POST['lastname']);
        }
      } else {
        $lastname = test_input($_POST['lastname']);
      }

      if(!empty($_POST['phone'])) {
        if(!preg_match("/^[+0-9]*$/", $phone)) {
          $phoneErr = 'Phone format is invalid!';
        } else {
          $phone = test_input($_POST['phone']);
        }
      } else {
        $phone = test_input($_POST['phone']);
      }

      if (empty($_POST['email'])) {
        $emailErr = "E-mail address is required!";
      } else {
        $email = test_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid e-mail format!";
        }
      }

      if (empty($_POST['comments'])) {
        $commentsErr = 'Comments are required!';
      } else {
        $comments = test_input($_POST['comments']);
      }

      if (($firstnameErr == '') && ($lastnameErr == '') && ($phoneErr == '') && ($emailErr == '') && ($commentsErr == '')) {
        $destination_url = "submit-comment.php";

        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['phone'] = $phone;
        $_SESSION['email'] = $email;
        $_SESSION['comments'] = $comments;

        header("Location: $destination_url");
        exit();
      }

    }
    ?>
    <div id="comment-header">
    <br><br><br>
      <div id="contact-text">
        Please use the form below to leave us a message, whether you have comments, questions <br>
        or would like to offer help as a volunteer and we will contact you shortly.
      </div>
      <br><br><br>
      <form class="contact-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div id="firstname-label">First Name:</div>
        <input type="text" name="firstname" id="firstname-field"><br>
        <span class="error" id="error-firstname"><?php echo $firstnameErr ?></span>

        <div id="lastname-label">Last Name:</div>
        <input type="text" name="lastname" id="lastname-field"><br>
        <span class="error" id="error-lastname"><?php echo $lastnameErr; ?></span>

        <div id="phone-label">Phone Number:</div>
        <input type="text" name="phone" id="phone-field"><br>
        <span class="error" id="error-phone"><?php echo $phoneErr; ?></span>

        <div id="email-label">E-mail address:</div>
        <input type="text" name="email" id="email-field"><br>
        <span class="error" id="error-email"><?php echo $emailErr; ?></span>

        <div id="comments-label">Comments:</div>
        <textarea rows="6" cols="22" name="comments" id="comments-field"></textarea><br>
        <span class="error"q id="error-comments"><?php echo $commentsErr; ?></span>
        <input type="submit" id="contact-button">
        <!-- <img src="captcha.php" alt="security code" /> -->
      </form>
    </div>
  </body>
</html>
