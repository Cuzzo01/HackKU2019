<?php
  include 'mysqlLogin.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  $username = $_SESSION['username'];
  $gameCode = $_SESSION['gameCode'];
  $conn->select_db("game_$gameCode");
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
  $row = mysqli_fetch_array($result);
  if ($row['nextAction'] == 'userPlay') {
    mysqli_query($conn, "UPDATE users SET nextAction = 'dealerPlays' WHERE username = '$username';") or die(mysqli_error($conn));
    $result = mysqli_query($conn, "UPDATE users SET ready = TRUE WHERE username = '$username';") or die(mysqli_error($conn));
  }
  header("Location: ../game.php?reload=true");
?>
