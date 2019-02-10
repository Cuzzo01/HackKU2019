<?php
  function resetDeck($conn) {
    $gameCode = $_SESSION['gameCode'];
    $conn->select_db("game_$gameCode");
    $result = mysqli_query($conn, "SELECT * FROM users") or die(mysqli_error($conn));
    while ($row = mysqli_fetch_array($result)) {
      $userID = $row['ID'];
      $tableName = $userID . "hand";
      $result2 = mysqli_query($conn, "SELECT * FROM $tableName") or die(mysqli_error($conn));
      while ($row = mysqli_fetch_array($result2)) {
        $card = $row['card'];
        mysqli_query($conn, "INSERT INTO unusedCards (card) VALUES ('$card')") or die(mysqli_error($conn));
      }
      mysqli_query($conn, "DELETE FROM $tableName") or die(mysqli_error($conn));
    }
    $result = mysqli_query($conn, "SELECT * FROM dealerHand") or die(mysqli_error($conn));
    while ($row = mysqli_fetch_array($result)) {
      $card = $row['card'];
      mysqli_query($conn, "INSERT INTO unusedCards (card) VALUES ('$card')") or die(mysqli_error($conn));
    }
    mysqli_query($conn, "DELETE FROM dealerHand") or die(mysqli_error($conn));
  }
 ?>
