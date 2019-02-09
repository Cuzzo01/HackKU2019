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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../css/bet.css">

    <title>Card Game</title>
</head>
<body>
  <div class = "container-fluid" id="betDiv">
    <h3 id="enterBet">Enter Bet amount</h3>
    <label for="coins">Coins Available:
      <?php
        $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
        $row = mysqli_fetch_array($result);
        echo $row['coins'];
      ?>
    </label>
    <form id="betInfo">
      <input type="text" class="form-container-fluid" name="betAmt" id="betInput">
      <button type = "button" class="btn btn-primary" id-"submitBtn" onclick="possibleBet()">Submit</button>
    </form>
  </div>

</body>
