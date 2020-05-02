<?php

if(isset($_POST['loginButton'])) {
  $username = $_POST['loginUsername'];
  $password   = $_POST['loginPassword'];
  $successful = $account->login($username, $password, $dbh);
  if($successful){
    $_SESSION['userLoggedIn'] = $username;
    header('Location: index.php');
  }
  
}




?>
