<?php
  include "deal.php";
  include "dealerAI.php";
  include "findWinners.php";
  include "resetDeck.php";

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
    if ($row['value'] == 'bet') {
      mysqli_query($conn, "UPDATE settings SET value = 'userPlay' WHERE setting = 'nextGameStep'") or die(mysqli_error($conn));
      mysqli_query($conn, "UPDATE users SET ready = FALSE") or die(mysqli_error($conn));
      mysqli_query($conn, "UPDATE users SET nextAction = 'userPlay'") or die(mysqli_error($conn));
    } else if ($row['value'] == 'userPlay') {
      $result = mysqli_query($conn, "UPDATE settings SET value = 'dealerPlays' WHERE setting = 'nextGameStep'") or die(mysqli_error($conn));
      $result = mysqli_query($conn, "UPDATE users SET nextAction = 'userPlay'") or die(mysqli_error($conn));
      $result = mysqli_query($conn, "UPDATE users SET ready = FALSE") or die(mysqli_error($conn));
      deal($conn, "dealer", 2);
      $result = mysqli_query($conn, "SELECT * FROM users") or die(mysqli_error($conn));
      while ($row = mysqli_fetch_array($result)) {
        deal($conn, $row['ID'], 2);
      }
    } else if ($row['value'] == 'dealerPlays') {
      mysqli_query($conn, "UPDATE settings SET value = 'revealResults' WHERE setting = 'nextGameStep'") or die(mysqli_error($conn));
      playDealer($conn);
    } else if ($row['value'] == 'revealResults') {
      mysqli_query($conn, "UPDATE settings SET value = 'resetCardsAndGame' WHERE setting = 'nextGameStep'") or die(mysqli_error($conn));
      findWinners($conn);
      mysqli_query($conn, "UPDATE users SET ready = FALSE") or die(mysqli_error($conn));
      mysqli_query($conn, "UPDATE users SET nextAction = 'resetCardsAndGame'") or die(mysqli_error($conn));
    } else if ($row['value'] == 'resetCardsAndGame') {
      mysqli_query($conn, "UPDATE users SET ready = FALSE") or die(mysqli_error($conn));
      mysqli_query($conn, "UPDATE settings SET value = 'userPlay' WHERE setting = 'nextGameStep'") or die(mysqli_error($conn));
      resetDeck($conn);
      mysqli_query($conn, "UPDATE users SET nextAction = 'bet'") or die(mysqli_error($conn));
      //header("Location: bet.php");
    }
  }
?>
