<?php
  include("../../config.php");
  if(isset($_POST['playlistId'])) {
    $playlistId = $_POST['playlistId'];

    $query = $dbh->prepare("DELETE FROM `playlist` WHERE `id` = :play");
    $query->bindParam(':play', $play);
    $play = $playlistId;
    $query->execute();
  }
  else {
    echo "Playlist not found.";
}
 ?>
