<?php
  include("includes/includedFile.php");
  include("includes/classes/random5Songs.php");
  if(isset($_GET['id'])) {
    $artistId = $_GET['id'];
  }
  else {
    header("Location: index.php");
  }
  $artist = new RandomArtist($dbh, $artistId);

 ?>



<div class="entityInfo">
  <div class="centerSection">
    <div class="artistInfo">
      <h1 class="artistName"><?php echo $artist->getName();?></h1>

      <div class="headerButtons">
        <button class="button" onclick="playFirstSong()">play</button>
      </div>
    </div>
  </div>
  <hr style="width: 651px; color:red; height:0.1px; margin-top:10px;">
</div>


<div class="SongsContainer" style="clear:both;">
  <h2 class="arti">SONGS</h2>
  <div class="songs">
    <ul class="trackList">
    <?php
      $i=1;
      //$album = new Artist($dbh, $artistId);
      $songsIdArray = $artist->getSongs();
      $songs = new Song($dbh, $artistId);
      $artists = $songs->getArtist($artistId);
      foreach ($songsIdArray as $song) {
        if($i>5) break;
        echo "<li class='trackListRow'>
             <div class='trackCount'>
                 <img class='play' src='assests/images/icons/playSong.png' onclick='setTracks(\"".$song['id']."\", tempPlayList, true)'>
                 <span class='trackNumber'>".$i."</span>
             </div>

             <div class='trackInfo'>
             <span class='trackName'>".$song['title']."</span>"
             ." </div>

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
        var tempSongIds = '<?php echo json_encode($songsIdArray)?>';
        tempPlayList =  JSON.parse(tempSongIds);
        var sliced = [];
        for (var i=0; i<5; i++)
            sliced[i] = tempPlayList[i];
        tempPlayList = sliced;
        // console.log(sliced);
        // console.log(tempPlayList[0]);
     </script>
   </ul>
  </div>
</div>
<hr style="width: 651px;">
<div class="gridViewContainer">
<h2 class="arti">ALBUMS</h2>
  <?php
     $sql = "SELECT * FROM `albums` WHERE `artist`=:artiId";
     $query = $dbh->prepare($sql);
     $query->bindParam(':artiId', $arti, PDO::PARAM_INT);
     $arti = $artistId;
     $query->execute();
     $results = $query->fetchAll(PDO::FETCH_ASSOC);
     if($query->rowCount() > 0)
     {
       foreach($results as $result) {
         echo "<div class='gridViewItem'>
                <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $result['id'] ."\")'>
                  <img src='" .$result['artWorkPath']. "'>" .
                  "<div class='gridViewInfo'>" . $result['title'] . "</div>
                  </span>" .
                      "</div>";
       }
     }
  ?>
</div>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistDropdown($dbh, $userLoggedIn->getUsername() );?>
    <div class="item">Copy image link</div>
</nav>
