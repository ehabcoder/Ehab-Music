<div id="navBarContainer">
  <nav class="navBar">
   <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo" >
     <img src="assests/images/icons/logo.png">
     <span class='name'> Ehab! Music </span>
   </span>
  <div class="group">
    <div class="navItem">
        <span role='link' tabindex='0' onclick="openPage('search.php')" class="navItemLink">
          Search
        <img src="assests/images/icons/search.png" class="icon" alt="search">
        <span>
    </div>
  </div>
 <div class="group">
   <div class="navItem">
     <span role="link" tabindex="0" onclick="openPage('browes.php')" class="navItemLink">Browse</span>
   </div>
   <div class="navItem">
     <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">Your Music</span>
   </div>
   <div class="navItem">
     <span role="link" tabindex="0" onclick="openPage('settings.php')" class="navItemLink"><?php
     include("includes/classes/User.php");
     $userforNav = new User($dbh, $_SESSION['userLoggedIn']);
      echo $userforNav->getWholeUsername();?></span>
   </div>
 </div>
</nav>
</div>
