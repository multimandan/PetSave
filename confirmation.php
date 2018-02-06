<html>

  <head>
    <title>Thank you!</title>
    <link rel="stylesheet" href="main.css" type="text/css" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  </head>

  <body class="donations">
    <div class="thank-you">
      <p id="donation-acknowledgment1">
        <?php
          session_start();
          sleep(1);
          $name = $_SESSION['name'];
          $amount = $_SESSION['amount'];
          $cardnumber = $_SESSION['cardnumber'];
          $expirydate = $_SESSION['expirydate'];
          $cvvcode = $_SESSION['cvvcode'];
          $cardholder = $_SESSION['cardholder'];
          try {
            $dbhost = "localhost";
            $database = "PetDB";
            $username = "db_user";
            $password = "password";
            $table = "donation_table";

            $connection = new PDO("mysql:host=$dbhost;dbname=$database", $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $insertstatement = $connection->prepare("INSERT INTO " . $table . " (donation_transaction, donation_amount, donation_donor, donation_type) VALUES (:donation_transaction, :donation_amount, :donation_donor, :donation_type)");

            $donation_transaction = generate_transaction_number($cardnumber);
            $donation_amount = $amount;
            $donation_donor = $cardholder;
            $donation_type = "Credit Card";

            $insertstatement->bindParam(':donation_transaction', $donation_transaction);
            $insertstatement->bindParam(':donation_amount', $donation_amount);
            $insertstatement->bindParam(':donation_donor', $donation_donor);
            $insertstatement->bindParam(':donation_type', $donation_type);
            $insertstatement->execute();
          }
          catch (PDOException $p) {
            echo "Error " . $p->getMessage();
            die();
          }
          //echo "Submission successful".
          $connection = null; // closes the connection
          //}
          //}

          function generate_transaction_number($cardnumber) {
            $seed = rand(111111, 999999);
            $lastdigits= '';
            $lastdigits = substr($cardnumber, (strlen($cardnumber) - 3), strlen($cardnumber));
            $transaction = $seed . "CX" . $lastdigits;
            return $transaction;
          }

        ?>
      Thank you! Your donation has been processed.
      <br>
      <p id="donation-acknowledgment2">
      The amount donated: <?php echo $_SESSION['amount'] . " Euros."; ?>
      </p>
      <br>
      <p id="donation-acknowledgment3">
      The confirmation number is: <?php echo generate_transaction_number($_SESSION['cardnumber']); ?>
      </p>
      <input type="button" onclick="location.href='index.php'" id="back-to-main" value="Back to Main Page" />
    </div>
  </body>

</html>
