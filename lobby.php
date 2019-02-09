<?php
  include 'helpers/mysqlLogin.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  $gameCode = $_SESSION['gameCode'];
  $conn->select_db("game_$gameCode");
  $result = mysqli_query($conn, "SELECT * FROM settings WHERE setting = 'gameStarted'") or die(mysqli_error($conn));
  $row = mysqli_fetch_array($result);
  if ($row['value'] != 'FALSE') {
    header("Location: ../game.php");
  }
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="5" >

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../css/lobby.css">

    <title>Card Game</title>
</head>
<body>
  <div class="container-fluid" id="gameCodeContainer">
    Game Code: <span class="container" id="gameCode"><?php echo $gameCode ?></span>
  </div>
  <div class = "container" id = "playerList">
    <table class="table table-dark">
      <?php
        $conn->select_db("game_$gameCode");
        $result = mysqli_query($conn, "SELECT * FROM users") or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($result)) {
          if ($row['username'] == $_SESSION['username']) {
            echo "<tr><td><b>" . $row['username'] . "</b></td></tr>";
          } else {
            echo "<tr><td>" . $row['username'] . "</td></tr>";
          }
        }
      ?>
    </table>
  </div>
  <div class = "container-fluid" id = "gameStart">
    <?php
      $username = $_SESSION['username'];
      $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
      $row = mysqli_fetch_array($result);
      if ($row['ID'] == 1) {
        echo "<a href='helpers/startGame.php'><button type='button' class='btn btn-primary' id='gameStart'>Start Game</button></a>";
      }
      $conn->close();
    ?>
  </div>
</body>
