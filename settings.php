<?php
  include("includes/includedFile.php");
  $user = new User($dbh, $_SESSION['userLoggedIn']);
?>

  <div class='entityInfo'>
    <div class="username">
      <?php echo $user->getWholeUsername(); ?>
    </div>
    <div class="details final" onclick="openPage('details.php')">
      DETAILS
    </div>
    <div class="logout final" onclick="logout()">
      LOGOUT
    </div>
  </div>
