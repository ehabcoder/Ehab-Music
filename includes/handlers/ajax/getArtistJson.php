<?php
  include("../../config.php");

  if(isset($_POST['artistId'])) {
    $artistId = $_POST['artistId'];
    $sql = "SELECT * FROM `artist` WHERE `id` = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $iid, PDO::PARAM_INT);
    $iid = $artistId;
    $query->execute();
    $resultArray = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultArray);
  }


 ?>
