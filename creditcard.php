<?php

session_start();

include ("footer.php");

$amount = $cardnumber = $expirydate = $cvvcode = $cardholder = "";
$nameErr = $amountErr = $cardnumberErr = $expirydateErr = $cvvcodeErr = $cardholderErr = '';
$destination_url = '';

// data validity verification for all fields
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (empty($_POST['name'])) {
    $nameErr = 'Name is required';
  } else {
    $name = test_input($_POST['name']);
    if(!preg_match("/^[a-zA-Z -]*$/", $name)) {
      $nameErr = 'Only letters, spaces and hyphens are accepted';
    }
  }

  if (empty($_POST['amount'])) {
    $amountErr = 'Amount is required';
  } else {
    // validate Amount
    $amount = test_input($_POST['amount']);
    if (!preg_match("/[^0-9]*$/", $amount)) {
      $amountErr = 'Only numbers (whole amounts) are accepted';
    }
  }
  if (empty($_POST['cardnumber'])) {
    $cardnumberErr = 'Credit card number is required';
  } else {
    // validate card number
    $cardnumber = test_input($_POST['cardnumber']);
    if (!preg_match("/^[0-9]{12,16}/", $cardnumber)) {
      $cardnumberErr = 'Card number invalid';
    }
  }
  if (empty($_POST['expirydate'])) {
    $expirydateErr = 'Expiry date is required';
  } else {
    // validate expiry date
    $expirydate = test_input($_POST['expirydate']);
    if (!preg_match("/^[0-9]{4}/", $expirydate)) {
      $expirydateErr = 'Only four digits are accepted for the expiry date (MMYY)';
    }
  }
  if (empty($_POST['cvvcode'])) {
    $cvvcodeErr = 'CVV code is required';
  } else {
    // validate cvv code
    $cvvcode = test_input($_POST['cvvcode']);
    if (!preg_match("/^[0-9]{3}/", $cvvcode)) {
      $cvvcodeErr = 'Only three digits are accepted for the CVV code';
    }
  }
  if (empty($_POST['cardholdername'])) {
    $cardholderErr = 'Cardholder name is required';
  } else {
    // validate cardholder name
    $cardholder  = test_input($_POST['cardholdername']);
    if (!preg_match("/^[A-Za-z -]/", $cardholder)) {
      $cardholderErr = 'Only characters, hyphens and white spaces are allowed';
    }
  }

  if (($nameErr == '') && ($amountErr == '') && ($cardnumberErr == '') && ($expirydateErr == '') && ($cvvcodeErr == '') && ($cardholderErr == '')) {
    $destination_url = 'confirmation.php';
    $_SESSION['name'] = $name;
    $_SESSION['amount'] = $amount;
    $_SESSION['cardnumber'] = $cardnumber;
    $_SESSION['expirydate'] = $expirydate;
    $_SESSION['cvvcode'] = $cvvcode;
    $_SESSION['cardholder'] = $cardholder;
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

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="main.css" type="text/css"/>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>PetSave - Donation Form</title>
</head>

<body>
<div id="donation">Donation by Credit Card</div>
<form action="<?php $action = htmlspecialchars($_SERVER["PHP_SELF"]); echo $action; ?>" method="post">

  <input type="text" id="name-field" name="name" placeholder="Name"/>
  <span class="error" id="error-donorname">
    <?php echo $nameErr; ?>
  </span>

  <input type="text" id="amount-field" name="amount" placeholder="Amount"/>
  <span class="error" id="error-donoramount">
    <?php echo $amountErr; ?></span>

  <input type="text" id="cardnumber-field" name="cardnumber" placeholder="Card Number" />
  <span class="error" id="error-donorcard">
    <?php echo $cardnumberErr; ?>
  </span>

  <input type="text" id="expirydate-field" name="expirydate" placeholder="Expiration Date"/>
  <span class="error" id="error-donorcardexpiry">
    <?php echo $expirydateErr; ?>
    </span>

  <input type="text" id="cvvcode-field" name="cvvcode" placeholder="CVV Code"/>
  <span class="error" id="error-donorcvvcode">
    <?php echo $cvvcodeErr; ?>
  </span>

  <input type="text" id="cardholdername-field" name="cardholdername" placeholder="Cardholder Name"/>
  <span class="error" id="error-donorcardholder">
    <?php echo $cardholderErr; ?>
  </span>

  <input name="submit" type="submit" id="donation-submit" value="Submit" />
  <input type="button" onclick="location.href='donate.php'" id="donation-back" value="Cancel" />

</form>
</body>
</html>
