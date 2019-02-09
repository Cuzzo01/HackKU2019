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
    echo $conn->error;
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
  $conn->close();
?>
