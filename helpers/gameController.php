<?php
  include "deal.php";

  function gameTick($conn) {
    $result = mysqli_query($conn, "SELECT * FROM users WHERE ready = 'FALSE'") or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);
    if ($count == 0) {
      advanceGame($conn);
    } else {
      return;
    }
  }

  function advanceGame($conn) {
    $result = mysqli_query($conn, "SELECT * FROM settings WHERE setting = 'nextGameStep'") or die(mysqli_error($conn));
    $row = mysqli_fetch_array($result);
    if ($row['value'] == 'usersPlay') {
      $result = mysqli_query($conn, "UPDATE settings SET value = 'dealerPlays' WHERE setting = 'nextGameStep'") or die(mysqli_error($conn));
      $result = mysqli_query($conn, "UPDATE users SET nextAction = 'userplay'") or die(mysqli_error($conn));
      $result = mysqli_query($conn, "UPDATE users SET ready = FALSE") or die(mysqli_error($conn));
      deal($conn, "dealer", 2);
      $result = mysqli_query($conn, "SELECT * FROM users") or die(mysqli_error($conn));
      while ($row = mysqli_fetch_array($result)) {
        deal($conn, $row['ID'], 2);
      }
    } else if ($row['value'] == 'dealerPlays') {
      echo "ready for dealer to play";
      die();
      $result = mysqli_query($conn, "UPDATE settings SET value = 'revealResults' WHERE setting = 'nextGameStep'") or die(mysqli_error($conn));

    }
  }
?>
