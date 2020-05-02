<?php include("includes/includedFile.php");

if(isset($_GET['id'])) {
  $playlistId = $_GET['id'];
}
else {
   header("Location: index.php");
}

$playlist = new Playlist($dbh, $playlistId);
$owner = new User($dbh, $playlist->getOwner());

?>
<h1 class="theEnd">To add songs you should go the the music and add it manually ^_^ </h1>

<div class="entityInfo new">
  <div class="leftSection">
    <img src="assests/images/icons/playlist.png">
  </div>

  <div class="rightSection">
      <h2><?php echo $playlist->getName();?></h2>
      <p>  by <?php echo $playlist->getOwner(); ?> </p>
      <p> <?php
        if($playlist->getNumberOfSongs()->rowCount()>1){echo $playlist->getNumberOfSongs()->rowCount() . ' Songs';}
        else {echo $playlist->getNumberOfSongs()->rowCount() . ' song';}
      ?> </p>
      <button class="green" onclick='deletePlaylist(<?php echo $playlistId; ?>)'>DELETE PLAYLIST</button>
  </div>
</div>

<div class="SongsContainer" style="clear:both;">
  <div class="songs">
    <ul class="trackList">
    <?php
      $i=1;

      //var_dump($playlist->getSongsId());
      // $playlistSongs = array();
      // for($i=0; $i<count($playlist->getSongsId()); $i++) {
      //     array_push($playlistSongs, $playlist->getSongsId()[$i]["songId"]);
      // }
      // var_dump($playlistSongs);
      function getSongsForPlaylists($id, $db) {
        $sql = "SELECT * FROM `songs` WHERE `id` = :id";
        $query = $db->prepare($sql);
        $query->bindParam(':id', $tempId);
        $tempId = $id;
        $query->execute();
        return $results = $query->fetchAll(PDO::FETCH_ASSOC);
      }

      $songsIdArray = $playlist->getSongs();


      //$songs = new Song($dbh, $albumId);
      //$artists = $songs->getArtist();
      foreach ($songsIdArray as $song) {
        $songs = getSongsForPlaylists($song['songId'], $dbh);
        $artist = new Artist($dbh, $songs[0]['artist']);
        echo "<li class='trackListRow'>
             <div class='trackCount'>
                 <img class='play' src='assests/images/icons/playSong.png' onclick='setTracks(\"".$songs[0]['id']."\", tempPlayList, true)'>
                 <span class='trackNumber'>".$i."</span>
             </div>

             <div class='trackInfo'>
             <span class='trackName'>".$songs[0]['title']."</span>"
             ."<span class='artistName'>".$artist->getNameForPlaylists()."</span>
             </div>

             <div class='trackOptions'>
                <input type='hidden' class='songId' value='" . $songs[0]['id'] . "'>
                <img class='optionsButton' src='assests/images/icons/more.png' onclick='showOptionsMenu(this)'>
             </div>

             <div class='trackDuration'>
             <span class='duration'>".$songs[0]['duration']."</span>".
            "</div></li>";
        $i++;
      }

     ?>
     <script>

        var tempSongIds = '<?php echo json_encode($playlist->getSongsId());?>';
        tempPlayList =  JSON.parse(tempSongIds);
        console.log(tempPlayList);

     </script>
   </ul>
  </div>
</div>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistDropdown($dbh, $userLoggedIn->getUsername() );?>
    <div class="item" onclick="deleteSongFromPlaylist(this, '<?php echo $playlistId; ?>')">Delete from playlist ?</div>
</nav>
