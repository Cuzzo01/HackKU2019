<?php
  include 'mysqlLogin.php';

  $gameCode = $_POST["gameCode"];
  $conn->select_db("settings");
  $result = mysqli_query($conn, "SELECT * FROM gameCodes WHERE code = '$gameCode'");
  $count = mysqli_num_rows($result);
  if ($count == 0) {
    header("Location: ../join.html?err=1");
  }

  if (!isset($_SESSION)) {
    session_start();
  }
  $_SESSION['gameCode'] = $_POST["gameCode"];
  $_SESSION['username'] = $_POST["username"];
  $gameCode = $_SESSION['gameCode'];
  $username = $_SESSION['username'];
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
