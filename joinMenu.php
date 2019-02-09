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
    <link rel="stylesheet" href="../css/joinMenu.css">

      <!-- Javascript files -->
      <script type="text/javascript" src="../js/script.js"></script>

    <title>Card Game</title>
</head>
<body onload="readVariables()">
  <div class="container-fluid" id="header">
      CardSimulator
  </div>
  <div class = "container-fluid" id="joinCode">
    <h3 id="enterCode">Enter Join Code</h3>
    <form id="loginData">
      <input type="text" class="form-container-fluid" name="gameCode" id="codeInput">
      <h3 id = "pickName">Name</h3>
      <input type="text" class="form-container-fluid" name="username" id="nameInput">
    </form>
  </div>

  <div class = "container-fluid" id="joinBtn">
    <button type="button" class="btn btn-primary" id="joinBtn" onclick="validateJoinInfo()">Join Game</button>
  </div>

</body>
</html>
