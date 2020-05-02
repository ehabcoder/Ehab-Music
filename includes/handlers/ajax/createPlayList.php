<?php
  include("../../config.php");
  if(isset($_POST['name']) && isset($_POST['user'])) {
    $name = $_POST['name'];
    $username = $_POST['user'];
    $dare = date("Y-m-d");

    $query = $dbh->prepare("INSERT INTO `playlist`(`name`,`owner`,`dateCreated`) VALUES (:name, :user, :dare)");
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':user', $username, PDO::PARAM_STR);
    $query->bindParam(':dare', $dare);
    $query->execute();
  }
  else {
    echo "Name or username parameters not passed into file";
  }

 ?>
