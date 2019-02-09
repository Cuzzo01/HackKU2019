<?php
  include 'mysqlLogin.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  $gameCode = $_SESSION['gameCode'];
  $conn->select_db("game_$gameCode");
  $result = mysqli_query($conn, "UPDATE settings SET value = TRUE WHERE setting = 'gameStarted';") or die(mysqli_error($conn));
  header("Location: ../game.php");
 ?>
