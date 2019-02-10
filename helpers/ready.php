<?php
  include 'mysqlLogin.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  $username = $_SESSION['username'];
  $gameCode = $_SESSION['gameCode'];
  $conn->select_db("game_$gameCode");
  mysqli_query($conn, "UPDATE users SET ready = TRUE WHERE username = '$username';") or die(mysqli_error($conn));
  header("Location: ../waiting.php");
 ?>
