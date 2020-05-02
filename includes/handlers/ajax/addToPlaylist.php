<?php
include("../../config.php");
if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
  $playlistId = $_POST['playlistId'];
  $songId = $_POST['songId'];

 //FIRST I NEED TO SELECT THE POSITION I WILL INSERT INTO IT:
 $sql = "SELECT MAX(playlistOrder) + 1 AS `playlistOrder` FROM `playlistsongs` WHERE `playlistId` = ?";
 $query = $dbh->prepare($sql);
 $query ->execute([$playlistId]);
 $order = $query->fetchAll(PDO::FETCH_ASSOC);

//SECOND INSERT INTO IT
 $sql2 = "INSERT INTO `playlistsongs` (`id`, `songId`, `playlistId`, `playlistOrder`)
          VALUES(:iid, :fsongId, :splaylistId, :tplaylistOrder)";
 $query2 = $dbh->prepare($sql2);
 $query2->execute([
    ':iid' => "",
    ':fsongId' => $songId,
    ':splaylistId' => $playlistId,
    ':tplaylistOrder' => (int)$order[0]['playlistOrder'],
 ]);
}
else {
  echo "Something wrong please try again.";
}
