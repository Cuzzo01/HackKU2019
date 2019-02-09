<?php
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
      $result = mysqli_query($conn, "UPDATE settings SET value = 'usersPlay' WHERE setting = 'nextGameStep'") or die(mysqli_error($conn));
    }
  }
?>
