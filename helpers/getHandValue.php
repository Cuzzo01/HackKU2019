<?php
  function getHandValue($conn, $playerID) {
    $numAces = 0;
    $sum = 0;
    $result;
    if ($playerID == 'dealer') {
      $result = mysqli_query($conn, "SELECT * FROM dealerHand") or die(mysqli_error($conn));
    } else {
      $result = mysqli_query($conn, "SELECT * FROM dealerHand") or die(mysqli_error($conn));
    }
    while ($row = mysqli_fetch_assoc($result)) {
      echo "Sum is: " . $sum;
      if (getCardValue($row['card']) == 1) {
        $numAces ++;
        $sum += 11;
      } else {
        $sum += getCardValue($row['card']);
      }
    }
    while ($sum > 21 && $numAces > 0) {
      $sum -= 10;
      $numAces --;
    }
    return $sum;
  };

  function getCardValue($card) {
    $value = substr($card, -1);
    echo $value;
    die();
    if ($value == 'Q' || $value == 'K' || $value == 'J') {
      echo "Found face card.";
      return 10;
    } else if ($value == 'A') {
      return 1;
    } else {
      return $value;
    }
  };
 ?>
