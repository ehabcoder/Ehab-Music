<?php include("includes/includedFile.php");

if(isset($_GET['id'])) {
  $albumId = $_GET['id'];
}
else {
   header("Location: index.php");
}
$album = new Album($dbh, $albumId);

function artist($id, $db) {
  $sql = "SELECT `name` FROM `artist` WHERE `id` = (SELECT `artist` from `albums` WHERE `id`=:id)";
  $artistQuery = $db->prepare($sql);
  $artistQuery->bindParam(':id', $artistName);
  $artistName = $id;
  $artistQuery->execute();
  $artists = $artistQuery->fetchAll(PDO::FETCH_ASSOC);
  //var_dump($artists);
  return $artists[0]['name'];
}
?>

<div class="entityInfo new">

  <div class="leftSection">
    <img src="<?php echo $album->getArtWorkPath();?>" alt="<?php echo $album->getTitle();?>">
  </div>

  <div class="rightSection">
      <h2><?php echo $album->getTitle();?></h2>
      <p>  by <?php echo artist($albumId,$dbh);?> </p>
      <p> <?php
        if($album->getNumberOfSongs()>1){echo $album->getNumberOfSongs() . ' Songs';}
        else {echo $album->getNumberOfSongs() . ' song';}
      ?> </p>
  </div>
</div>

<div class="SongsContainer" style="clear:both;">
  <div class="songs">
    <ul class="trackList">
    <?php
      $i=1;

      $songsIdArray = $album->getSongs();
      $songs = new Song($dbh, $albumId);
      $artists = $songs->getArtist();

      foreach ($songsIdArray as $song) {
        echo "<li class='trackListRow'>
             <div class='trackCount'>
                 <img class='play' src='assests/images/icons/playSong.png' onclick='setTracks(\"".$song['id']."\", tempPlayList, true)'>
                 <span class='trackNumber'>".$i."</span>
             </div>

             <div class='trackInfo'>
             <span class='trackName'>".$song['title']."</span>"
             ."<span class='artistName'>".$artists->getName()."</span>
             </div>

             <div class='trackOptions'>
                <input type='hidden' class='songId' value='" . $song['id'] . "'>
                <img class='optionsButton' src='assests/images/icons/more.png' onclick='showOptionsMenu(this)'>
             </div>

             <div class='trackDuration'>
             <span class='duration'>".$song['duration']."</span>".
            "</div></li>";
        $i++;
      }

     ?>
     <script>
        var tempSongIds = '<?php echo json_encode($album->getSongsids());?>';
        tempPlayList =  JSON.parse(tempSongIds);
        // console.log(tempPlayList);
     </script>
   </ul>
  </div>
</div>


<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistDropdown($dbh, $userLoggedIn->getUsername() );?>
    <div class="item">Item 2</div>
    <div class="item">Item 3</div>
</nav>
