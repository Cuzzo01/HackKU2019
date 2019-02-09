<?php
  include 'helpers/mysqlLogin.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  $gameCode = $_SESSION['gameCode'];
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
          echo "<tr><td>" . $row['username'] . "</td></tr>";
        }
        $conn->close();
      ?>
    </table>
  </div>
  <div class = "container-fluid" id = "gameStart">
    <button type="button" class="btn btn-primary" id="gameStart">Start Game</button>
  </div>
</body>
