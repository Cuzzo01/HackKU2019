<?php
  include 'mysqlLogin.php';

  $gameCode = strtoupper($_POST['gameCode']);
  $username = strtoupper($_POST['username']);

  $conn->select_db("settings");
  $result = mysqli_query($conn, "SELECT * FROM gameCodes WHERE code = '$gameCode'");
  $count = mysqli_num_rows($result);
  if ($count == 0) {
    header("Location: ../joinMenu.php?err=1");
  }

  $conn->select_db("game_$gameCode");

  $newName = $username;
  while (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE username = '$newName'")) > 0) {
    $numToAdd = 2;
    $newName = $username . $numToAdd;
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$newName'");
    $count = mysqli_num_rows($result);
    if ($count != 0) {
      $numToAdd ++;
    } else {
      break;
    }
  }
  $username = $username . " " . $numToAdd;

  if (!isset($_SESSION)) {
    session_start();
  }

  $_SESSION['gameCode'] = $gameCode;
  $_SESSION['username'] = $username;

  $conn->select_db("game_$gameCode");

  $query = "INSERT INTO users (username) VALUES ('$username')";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $playerID = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'"))['ID'];
  $_SESSION['playerID'] = $playerID;
  $query = "CREATE TABLE " . $playerID . "hand (
              ID INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              card VARCHAR(2) NOT NULL
            )";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

  header("Location: ../lobby.php");
  $conn->close();
?>
