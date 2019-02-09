<?php
  include 'mysqlLogin.php';
  function randomString($length) {
    $str = "";
    $characters = array_merge(range('A','Z'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
      $rand = mt_rand(0, $max);
      $str .= $characters[$rand];
    }
    return $str;
  }

  function isValidNewGameCode($code, $conn) {
    $conn->select_db("settings");

    $result = mysqli_query($conn, "SELECT * FROM gameCodes WHERE code = '$code'");
  	$count = mysqli_num_rows($result);
    if ($count != 0) {
      return(false);
    } else {
      return(true);
    }
  }

  $gameCode = "RUBH";
  while(!isValidNewGameCode($gameCode, $conn)) {
    echo "Gamecode already used";
    $gameCode = randomString(4);
  }

  $result = mysqli_query($conn, "INSERT INTO gameCodes (code) VALUES ('$gameCode')");


  $result = mysqli_query($conn, "CREATE DATABASE game_$gameCode");
  $conn->select_db("game_$gameCode");
  $query = "CREATE TABLE users (
              ID INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              username VARCHAR(15) NOT NULL,
              coins int(32) NOT NULL DEFAULT '1000',
              bet int(32) NOT NULL DEFAULT 0,
              reg_date TIMESTAMP
            )";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $query = "CREATE TABLE unusedCards (
              ID INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              card VARCHAR(2) NOT NULL
            )";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $query = "INSERT INTO unusedCards
                (card)
            VALUES
                ('S2'), ('S3'), ('S4'), ('S5'), ('S6'), ('S7'), ('S8'), ('S9'), ('S1'), ('SJ'), ('SQ'), ('SK'), ('SA'),
                ('C2'), ('C3'), ('C4'), ('C5'), ('C6'), ('C7'), ('C8'), ('C9'), ('C1'), ('CJ'), ('CQ'), ('CK'), ('CA'),
                ('H2'), ('H3'), ('H4'), ('H5'), ('H6'), ('H7'), ('H8'), ('H9'), ('H1'), ('HJ'), ('HQ'), ('HK'), ('HA'),
                ('D2'), ('D3'), ('D4'), ('D5'), ('D6'), ('D7'), ('D8'), ('D9'), ('D1'), ('DJ'), ('DQ'), ('DK'), ('DA')
                ";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $query = "CREATE TABLE dealerHand (
              ID INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              card VARCHAR(2) NOT NULL
            )";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $query = "CREATE TABLE settings (
              ID INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              setting VARCHAR(20) NOT NULL,
              value VARCHAR(20) NOT NULL
            )";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));;
  $query = "INSERT INTO settings (setting,value) VALUES ('gameStarted', 'FALSE')";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));;
  header("Location: ../joinMenu.php?gameCode=$gameCode");

  $conn->close();
?>
