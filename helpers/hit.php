<?php
  include 'mysqlLogin.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  $username = $_SESSION['username'];
  $gameCode = $_SESSION['gameCode'];
  $conn->select_db("game_$gameCode");
  include 'deal.php';
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
  $row = mysqli_fetch_array($result);
  if ($row['nextAction'] != 'userplay') {
    header("Location: ../game.php");
  } else {
    deal($conn, $row['ID'], 1);
    header("Location: ../game.php");
  }
?>