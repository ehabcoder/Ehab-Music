<?php
  include("../../config.php");
  if(isset($_POST['albumId'])) {
    $art = $_POST['albumId'];
    $sql = "SELECT * FROM `albums` WHERE `id` = :id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $iid, PDO::PARAM_INT);
    $iid = $art;
    $query->execute();
    $resultArray = $query->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultArray);
  }
?>
