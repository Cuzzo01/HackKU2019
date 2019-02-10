<?php
  include 'mysqlLogin.php';
  include 'deal.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  $gameCode = $_SESSION['gameCode'];
  $conn->select_db("game_$gameCode");
  $result = mysqli_query($conn, "UPDATE settings SET value = TRUE WHERE setting = 'gameStarted';") or die(mysqli_error($conn));
  $result = mysqli_query($conn, "UPDATE users SET ready = FALSE;") or die(mysqli_error($conn));
  $result = mysqli_query($conn, "UPDATE users SET nextAction = 'bet';") or die(mysqli_error($conn));
  $result = mysqli_query($conn, "UPDATE settings SET value = 'usersPlay' WHERE setting = 'nextGameStep'") or die(mysqli_error($conn));
  // deal($conn, 'dealer', 2);
  // $result = mysqli_query($conn, "SELECT * FROM users") or die(mysqli_error($conn));
  // while ($row = mysqli_fetch_assoc($result)) {
  //   deal($conn, $row['ID'], 2);
  // }
  header("Location: ../game.php");
 ?>
