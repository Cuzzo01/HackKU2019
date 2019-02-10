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
    if ($row['nextAction'] == 'userPlay') {

    }
  }
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../css/game.css">

    <script type="text/javascript" src="../js/webSocket.js"></script>

    <title>Card Game</title>
</head>
<body onload="sendSync()">
    <div class="container-fluid" id="header">
        <h3 id="name"><?php echo $username ?></h3>
        <button type="button" class="btn btn-primary" id="menu">Menu</button>
    </div>
    <div class="container-fluid" id="otherPlayers">
      <?php
        $conn->select_db("game_$gameCode");
        $result = mysqli_query($conn, "SELECT * FROM users") or die(mysqli_error($conn));
        while ($row = mysqli_fetch_array($result)) {
          if ($row['username'] == $_SESSION['username']) {
            continue;
          } else {
            echo "<div class='container-fluid player'><label class='container-fluid' id='playerName'>";
            echo $row['username'];
            echo "</label><div class='container-fluid' id='status'>";
            if ($row['ready'] == TRUE) {
              echo "<image class='icon' src='CardCropped/stayed.png' height='20px'>";
            }
            echo "</div><div class='container-fluid' id='playerInfo'><div class='container-fluid' id='coinCount'>Coins: ";
            echo $row['coins'];
            echo "</div><div class='container-fluid' id='bet'>Bet: ";
            echo $row['bet'];
            echo "</div></div><div class='container pile pile3'>";
            $tableName = $row['ID'] . 'hand';
            $result2 = mysqli_query($conn, "SELECT * FROM $tableName") or die(mysqli_error($conn));
            while ($row = mysqli_fetch_array($result2)) {
              echo "<image class='card' src='../CardCropped/" . strtolower($row['card']) . ".png'>";
            }
            echo "</div></div>";
          }
        }
      ?>
    <div class="container-fluid" id="board">
      <label class="container-fluid" id="playerName">
        Board/Dealer
      </label>
        <div class="container pile pile2">
        <?php
          $result = mysqli_query($conn, "SELECT * FROM settings WHERE setting = 'nextGameStep'") or die(mysqli_error($conn));
          $row = mysqli_fetch_array($result);
          $hideCard = !($row['value'] == 'revealResults' || $row['value'] == 'resetCardsAndGame');
          $result = mysqli_query($conn, "SELECT * FROM dealerHand") or die(mysqli_error($conn));
          $first = TRUE;
          while ($row = mysqli_fetch_array($result)) {
            if ($first && $hideCard) {
              $first = FALSE;
              echo "<image class='card' src='../CardCropped/hidden.png'>";
            } else {
              echo "<image class='card' src='../CardCropped/" . strtolower($row['card']) . ".png'>";
            }
          }
        ?>
      </div>
    </div>
    <div class="container-fluid fixed-bottom" id="playerResources">
      <div class="container-fluid fixed-bottom" id="gameBtns">
        <?php
          $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
          $row = mysqli_fetch_array($result);
          if ($row['ready'] == FALSE && $row['nextAction'] == 'userPlay') {
            echo "<a href='helpers/hit.php'><button type='button' class='btn btn-primary' id='hitBtn'>Hit</button></a>";
            echo "<a href='helpers/stay.php'><button type='button' class='btn btn-primary' id='stayBtn'>Stay</button></a>";
          }
          if ($row['ready'] == FALSE && $row['nextAction'] == 'resetCardsAndGame') {
            echo "<a href='helpers/ready.php'><button type='button' class='btn btn-primary' id='nextBtn'>Next Hand</button></a>";
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
