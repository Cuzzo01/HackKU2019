<?php
  include 'helpers/mysqlLogin.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  $gameCode = $_SESSION['gameCode'];
  $conn->select_db("game_$gameCode");
  include 'helpers/getHandValue.php';
  include 'helpers/gameController.php';
  gameTick($conn);
  $username = $_SESSION['username'];
  $playerID = $_SESSION['playerID'];
  $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
  $row = mysqli_fetch_array($result);
  if (!$row['ready']) {
    if ($row['nextAction'] == 'bet') {
      header("Location: bet.php");
    }
    if ($row['nextAction'] == 'userPlays') {

    }
  }
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <meta http-equiv="refresh" content="5" > -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../css/game.css">

    <title>Card Game</title>
</head>
<body>
    <div class="container-fluid" id="header">
        <h3 id="name">Name</h3>
        <button type="button" class="btn btn-primary" id="menu">Menu</button>
    </div>
    <div class="container-fluid" id="otherPlayers">
      <div class="container-fluid player">
        <label class="container-fluid" id="playerName">
          Player1
        </label>
        <div class="container pile pile3">
        <?php
          $result = mysqli_query($conn, "SELECT * FROM dealerHand") or die(mysqli_error($conn));
          while ($row = mysqli_fetch_array($result)) {
            echo "<image class='card' src='../CardCropped/" . strtolower($row['card']) . ".png'>";
          }
        ?>
        </div>
      </div>
      <div class="container-fluid player">
        <label class="container-fluid" id="playerName">
          Player2
        </label>
        <div class="container pile pile3">
        <?php
          $result = mysqli_query($conn, "SELECT * FROM dealerHand") or die(mysqli_error($conn));
          while ($row = mysqli_fetch_array($result)) {
            echo "<image class='card' src='../CardCropped/" . strtolower($row['card']) . ".png'>";
          }
        ?>
        </div>
      </div>
      <div class="container-fluid player">
        <label class="container-fluid" id="playerName">
          Player3
        </label>
        <div class="container pile pile3">
        <?php
          $result = mysqli_query($conn, "SELECT * FROM dealerHand") or die(mysqli_error($conn));
          while ($row = mysqli_fetch_array($result)) {
            echo "<image class='card' src='../CardCropped/" . strtolower($row['card']) . ".png'>";
          }
        ?>
        </div>
      </div>
    </div>
    <div class="container-fluid" id="board">
      <label class="container-fluid" id="playerName">
        Board/Dealer
      </label>
        <div class="container pile pile2">
        <?php
          $result = mysqli_query($conn, "SELECT * FROM dealerHand") or die(mysqli_error($conn));
          while ($row = mysqli_fetch_array($result)) {
            echo "<image class='card' src='../CardCropped/" . strtolower($row['card']) . ".png'>";
          }
        ?>
      </div>
    </div>
    <div class="container-fluid fixed-bottom" id="playerResources">
      <div class="container-fluid fixed-bottom" id="gameBtns">
        <?php
          $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
          $row = mysqli_fetch_array($result);
          if ($row['ready'] == FALSE && $row['nextAction'] == 'userplay') {
            echo "<a href='helpers/hit.php'><button type='button' class='btn btn-primary' id='hitBtn'>Hit</button></a>";
            echo "<a href='helpers/stay.php'><button type='button' class='btn btn-primary' id='stayBtn'>Stay</button></a>";
          }
        ?>

      </div>
      <div class="container" id="personal">
          <div class="container" id="funds"><?php
                                              $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
                                              $row = mysqli_fetch_array($result);
                                              echo $row['coins'];
                                                ?> coins</div>
          <div class="container pile pile2">
            <?php
            $tableName = $playerID . "hand";
            $result = mysqli_query($conn, "SELECT * FROM $tableName") or die(mysqli_error($conn));
            while ($row = mysqli_fetch_array($result)) {
              echo "<image class='card' src='../CardCropped/" . strtolower($row['card']) . ".png'>";
            }
            $conn->close();
          ?>
        </image></div>
      </div>
    </div>
</body>
</html>
