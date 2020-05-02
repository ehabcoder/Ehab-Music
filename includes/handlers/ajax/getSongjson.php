<?php
include("../../config.php");
if(isset($_POST['songId'])) {
  $songId = $_POST['songId'];
  $sql = "SELECT * FROM `songs` WHERE `id` = :iid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':iid', $iid, PDO::PARAM_INT);
  $iid = $songId;
  $query->execute();
  $resultArray = $query -> fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($resultArray);
}

?>
