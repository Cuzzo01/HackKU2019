<?php
  if (!isset($_SESSION)) {
    session_start();
  }
  # UNCOMMENT WHEN IN PRODUCTION
  // if (isset($_SESSION)) {
  //   header("Location: ../lobby.php");
  // }
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../css/menu.css">

    <!-- Javascript files -->
    <script type="text/javascript" src="../js/script.js"></script>

    <title>Card Game</title>
</head>
<body>
    <div class="container-fluid" id="header">
        <h3 id="name">CardSimulator</h3>
    </div>

    <div class = "container-fluid" id="intro">
        <h3 id="intromsg">What would you like to do?</h3>
        <a href="helpers/createLobby.php"><button type="button" class="btn btn-primary" id="createGame">Create a Game</button></a>
        <a href="joinMenu.php"><button type="button" class="btn btn-primary" id="joinGame">Join a Game</button></a>
    </div>


</body>
</html>