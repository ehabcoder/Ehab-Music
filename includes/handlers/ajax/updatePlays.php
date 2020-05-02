<?php
include("../../config.php");
if(isset($_POST['songId'])) {
  $songId = $_POST['songId'];
  $sql = "UPDATE songs SET plays = plays+1 WHERE  id = :id";
  $query = $dbh->prepare($sql);
  $query->bindParam(':id', $iid, PDO::PARAM_INT);
  $iid = $songId;
  $query->execute();
}

?>
