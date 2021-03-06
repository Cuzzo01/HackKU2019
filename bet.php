<?php
  include 'helpers/mysqlLogin.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  $gameCode = $_SESSION['gameCode'];
  $conn->select_db("game_$gameCode");
  $username = $_SESSION['username'];
?>
<!doctype html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../css/bet.css">

    <script type="text/javascript" src="../js/script.js"></script>
    <script type="text/javascript" src="../js/webSocket.js"></script>
    <title>Card Game</title>
</head>
<body onload="sendSync()">
  <div class="container-fluid" id="header">
      CardSimulator
  </div>
  <div class = "container-fluid" id="betDiv">
    <h3 id="enterBet">Enter Bet amount</h3>
    <label for="coins">Coins Available:<span id="coins"><?php
        $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
        $row = mysqli_fetch_array($result);
        echo $row['coins'];
      ?>
      </span>
    </label>
  </div>
  <form id="betInfo">
    <input type="text" class="form-container-fluid" name="bet" id="betInput">
    <button type = "button" class="btn btn-primary" id-"submitBtn" onclick="possibleBet()">Submit</button>
  </form>

</body>
