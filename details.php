<?php include("includes/includedFile.php");
      $userForDetails = new User($dbh, $_SESSION['userLoggedIn']);
  ?>


<div class="container">
  <div class="emailContainer">
    <h1> EMAIL </h1>
    <input type="text" placeholder="Email" class="enail" value="<?php echo $userForDetails->getEmail(); ?>">
    <span class="message"> </span>
    <button class="final" onclick="updateEmail('.enail')">SAVE</button>
    <hr style="width: 651px; color:red; height:0.1px; margin-top:10px;">
  </div>
  <div class="passwordContainer">
    <h1> PASSWORD </h1>
    <input type="password" class="oldPass" name="oldPass" placeholder="Current password">
    <input type="password" class="newPass" name="newPass1" placeholder="New password">
    <input type="password" class="newPassCon" name="newPassCon" placeholder="Confirm password">
    <span class="message"></span>
    <button class="final" onclick="updatePassword('.oldPass','.newPass','.newPassCon')">SAVE</button>
  </div>
  </div
