<?php
  include 'mysqlLogin.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  $betAmount = $_POST['bet'];
  $username = $_SESSION['username'];
  $gameCode = $_SESSION['gameCode'];
  $conn->select_db("game_$gameCode");
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
  $row = mysqli_fetch_array($result);
  if ($betAmount > $row['coins']) {
    header("Location: ../bet.php");
  } else {
    $result = mysqli_query($conn, "UPDATE users SET bet = '$betAmount' WHERE username = '$username';") or die(mysqli_error($conn));
    $newCoins = $row['coins'] - $betAmount;
    $result = mysqli_query($conn, "UPDATE users SET coins = '$newCoins' WHERE username = '$username';") or die(mysqli_error($conn));
    $result = mysqli_query($conn, "UPDATE users SET ready = TRUE WHERE username = '$username'") or die(mysqli_error($conn));
    header("Location: ../waiting.php");
  }
?>
