<?php
  function findWinners($conn) {
    $dealerHandValue = getHandValue($conn, 'dealer');
    $gameCode = $_SESSION['gameCode'];
    $conn->select_db("game_$gameCode");
    $result = mysqli_query($conn, "SELECT * FROM users") or die(mysqli_error($conn));
    while ($row = mysqli_fetch_array($result)) {
      $handValue = getHandValue($conn, $row['ID']);
      if ($handValue > 21) {
        continue;
      }
      if ($dealerHandValue < $handValue || $dealerHandValue > 21) {
        $bet = $row['bet'];
        $userID = $row['ID'];
        $newCoins = (2 * $bet) + $row['coins'];
        mysqli_query($conn, "UPDATE users SET coins = '$newCoins' WHERE ID = '$userID';") or die(mysqli_error($conn));
      } else if ($dealerHandValue == $handValue) {
        $bet = $row['bet'];
        $userID = $row['ID'];
        $newCoins = ($bet) + $row['coins'];
        mysqli_query($conn, "UPDATE users SET coins = '$newCoins' WHERE ID = '$userID';") or die(mysqli_error($conn));
      } 
    }
  }
?>
