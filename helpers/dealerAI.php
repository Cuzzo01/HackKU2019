<?php
  function playDealer($conn) {
    while (getHandValue($conn, 'dealer') < 17) {
      deal($conn, 'dealer', 1);
    }
  }
 ?>
