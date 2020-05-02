<?php
include('../../config.php');

  if(!isset($_POST['user'])) {
      echo "username doesn't defined";
      exit();
  }

  if(isset($_POST['user']) && isset($_POST['old']) && isset($_POST['new1']) && isset($_POST['new2'])) {

    if($_POST['user']=="" || $_POST['old']=="" || $_POST['new1']=="" || $_POST['new2']=="" ) {
        echo "Please fill all the fields.";
        exit();
    }

    $username = $_POST['user'];
    $oldPassword = $_POST['old'];
    $newPassword = $_POST['new1'];
    $confirmPassword = $_POST['new2'];

    $mdOldPassword = md5($oldPassword);

    // check if it exist in the database
    $sql1 = "SELECT `password` FROM `users` WHERE `password`= :pass";
    $query1 = $dbh->prepare($sql1);
    $query1->bindParam(':pass', $password, PDO::PARAM_STR);
    $password = $mdOldPassword;
    $query1->execute();
    if($query1->rowCount()!=0) {
      echo "Sorry! the old password is not correct, try again.";
      exit();
    }

    if($newPassword != $confirmPassword) {
      echo "new password and confirm password don't match, try again.";
      exit();
    }

    if(!preg_match('/^[A-Za-z0-9]/', $newPassword)) {
      echo "Your password must only contain letter and/or numbers";
      exit();
    }

    if(strlen($newPassword)<5 || strlen($newPassword)>30) {
      echo "Your password must be between 5 and 30 characters";
    }

    // Update new password
    $mdnewPassword = md5($newPassword);
    $sql2 = "UPDATE `users` SET `password` = :new WHERE `username`=:user";
    $query2 = $dbh->prepare($sql2);
    $query2->bindParam(':new', $newPass, PDO::PARAM_STR);
    $query2->bindParam(':user', $use, PDO::PARAM_STR);
    $newPass = $mdnewPassword;
    $use = $username;
    $query2->execute();
    echo "Password successfully updated.";
  }
  else {
    echo "one of your fields doesn't set , please try again later.";
  }

 ?>
