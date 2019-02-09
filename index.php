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
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
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
        CardSimulator
    </div>

    <div class = "container-fluid" id="createDiv">
        <button type="button" class="btn btn-primary" id="createBtn">Create a Game</button>
    </div>

    <div class = "container-fluid" id="joinDiv">
      <button type="button" class="btn btn-primary" id="joinBtn">Join a Game</button>
    </div>

</body>
</html>
