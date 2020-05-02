<?php
include('../../config.php');
  if(!isset($_POST['user'])) {
      echo "username doesn't defined";
      exit();
  }

  if(isset($_POST['email']) && isset($_POST['user'])) {

    if($_POST['email']=="") {
        echo "email doesn't defined";
        exit();
    }

    // Check if email is already exists
    $sql1 = "SELECT `email`from `users` WHERE `email` = :email";
    $query1 = $dbh->prepare($sql1);
    $query1->bindParam(':email', $user1, PDO::PARAM_STR);
    $user1 = $_POST['email'];
    $query1->execute();
    if($query1->rowCount()>0) {
      echo "Sorry! this email currently exists.";
      exit();
    }
   // Check if email is valid
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "email is't correct please try again with a correct one. ";
        exit();
    }

  //if all ok then update it
    $sql = "UPDATE `users` SET `email` = :email WHERE `username` = :username";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email1, PDO::PARAM_STR);
    $query->bindParam(':username', $user1, PDO::PARAM_STR);
    $email1 = $_POST['email'];
    $user1 = $_POST['user'];
    $query->execute();
    echo 'Email successfully updated.';
  }
  else {
  echo "Something wrong please try again later.";
  }
 ?>
