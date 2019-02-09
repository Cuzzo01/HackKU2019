<?php
  include 'helpers/mysqlLogin.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  $gameCode = $_SESSION['gameCode'];
  $conn->select_db("game_$gameCode");
  $username = $_SESSION['username']
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

    <title>Card Game</title>
</head>
<body>
    <div class="container-fluid" id="header">
        <h3 id="name">Name</h3>
        <button type="button" class="btn btn-primary" id="menu">Menu</button>
    </div>
    <div class="container-fluid" id="board">
        <div class="container pile"><image class="card" src="../CardCropped/c2.png"><image class="card" src="../CardCropped/c6.png"></image></div>
    </div>
    <div class="container-fluid fixed-bottom" id="personal">
      <button type="button" class="btn btn-primary" id="hitBtn">Hit</button>
      <button type="button" class="btn btn-primary" id="stayBtn">Stay</button>
        <div class="container" id="funds"><?php
                                            $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
                                            $row = mysqli_fetch_array($result);
                                            echo $row['coins'];
                                              ?> coins
            </div>
        <div class="container pile"><image class="card" src="../CardCropped/d2.png"><image class="card" src="../CardCropped/h6.png"></image></div>
    </div>



</body>
</html>
