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
              bet int(32) NOT NULL,
              reg_date TIMESTAMP
            )";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));;
  $query = "CREATE TABLE unusedCards (
              ID INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              card VARCHAR(2) NOT NULL
            )";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));;
  $query = "INSERT INTO unusedCards
                (card)
            VALUES
                ('2S'), ('3S'), ('4S'), ('5S'), ('6S'), ('7S'), ('8S'), ('9S'), ('1S'), ('JS'), ('QS'), ('KS'), ('AS'),
                ('2C'), ('3C'), ('4C'), ('5C'), ('6C'), ('7C'), ('8C'), ('9C'), ('1C'), ('JC'), ('QC'), ('KC'), ('AC'),
                ('2H'), ('3H'), ('4H'), ('5H'), ('6H'), ('7H'), ('8H'), ('9H'), ('1H'), ('JH'), ('QH'), ('KH'), ('AH'),
                ('2D'), ('3D'), ('4D'), ('5D'), ('6D'), ('7D'), ('8D'), ('9D'), ('1D'), ('JD'), ('QD'), ('KD'), ('AD')
                ";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));;
  $query = "CREATE TABLE dealerHand (
              ID INT(32) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              card VARCHAR(2) NOT NULL
            )";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));;
  //header("Location: joinLobby.php?code=$gameCode");

  $conn->close();
?>
