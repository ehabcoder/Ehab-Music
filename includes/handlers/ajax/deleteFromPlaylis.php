<?php
  include("../../config.php");
  if(isset($_POST['songId']) && isset($_POST['playlistId'])) {
    $songId = $_POST['songId'];
    $playlistId = $_POST['playlistId'];

    // THE DELETION ...
    $sql = "DELETE FROM `playlistsongs` WHERE `songId` = :song AND `playlistId` = :playlist";
    $query = $dbh->prepare($sql);
    $query->bindParam(':song', $songId);
    $query->bindParam(':playlist', $playlistId);
    $query->execute();
  }
  else {
    echo "Something wrong! please try again later.";
  }

?>
