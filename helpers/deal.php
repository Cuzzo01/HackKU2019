<?php
  function deal($conn, $playerID, $numCards){
    $gameCode = $_SESSION['gameCode'];
    if ($playerID == 'dealer') {
      // $conn->select_db("game_$gameCode");
      $result = mysqli_query($conn, "SELECT * FROM unusedCards ORDER BY RAND() LIMIT $numCards") or die(mysqli_error($conn));
      while ($row = mysqli_fetch_assoc($result)) {
        $card = $row['card'];
        // remove card from unusedCards
        mysqli_query($conn, "DELETE FROM unusedCards WHERE card = '$card'") or die(mysqli_error($conn));
        // add card to dealer hand
        mysqli_query($conn, "INSERT INTO dealerHand (card) VALUES ('$card')") or die(mysqli_error($conn));
      }
    } else {
      $result = mysqli_query($conn, "SELECT * FROM unusedCards ORDER BY RAND() LIMIT $numCards") or die(mysqli_error($conn));
      while ($row = mysqli_fetch_assoc($result)) {
        $card = $row['card'];
        // remove card from unusedCards
        mysqli_query($conn, "DELETE FROM unusedCards WHERE card = '$card'") or die(mysqli_error($conn));
        // add card to dealer hand
        $tableName = $playerID . "hand";
        mysqli_query($conn, "INSERT INTO $tableName (card) VALUES ('$card')") or die(mysqli_error($conn));
      }
    }
  }
 ?>
