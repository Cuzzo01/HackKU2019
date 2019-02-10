<?php
  include 'helpers/mysqlLogin.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  $gameCode = $_SESSION['gameCode'];
  $conn->select_db("game_$gameCode");
  include 'helpers/gameController.php';
  gameTick($conn);
  $username = $_SESSION['username'];
  $playerID = $_SESSION['playerID'];
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
  $row = mysqli_fetch_array($result);
  if ($row['nextAction'] == 'userPlay') {
    header("Location: game.php");
  } else if ($row['nextAction'] == 'bet' && $row['ready'] == FALSE) {
    header("Location: bet.php");
  }
?>
<!doctype html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="5" >

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../css/waiting.css">

    <script type="text/javascript" src="../js/script.js"></script>

    <title>Card Game</title>
</head>
<body>
  <div class="container-fluid" id="header">
      CardSimulator
  </div>
  <div class="container-fluid" id="waitingMsg">
    Waiting for other players...
    <div class="sk-folding-cube">
    <div class="sk-cube1 sk-cube"></div>
    <div class="sk-cube2 sk-cube"></div>
    <div class="sk-cube4 sk-cube"></div>
    <div class="sk-cube3 sk-cube"></div>
  </div>
</div>
</body>
