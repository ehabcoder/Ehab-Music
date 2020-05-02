<?php
include("includes/includedFile.php");

if(isset($_GET['term'])) {
  $term = urldecode($_GET['term']);
}
else {
  $term = "";
}
?>

<div class="searchContainer">
  <h4 style="color: #bf23d3;"> Search for an artist, album or song</h4>
  <input type="text" class="searchInput" value="<?php echo $term;?>" placeholder="Type something..." onfocus="this.value = this.value">
</div>

<script>
$(".searchInput").focus();
  $(function() {
    $(".searchInput").keyup(function() {
      clearTimeout(timer);
      timer = setTimeout(function(){
        let val = $(".searchInput").val();
        openPage("search.php?term="+val);
      }, 2000);
    });
  });
</script>

<?php if($term=="") exit();?>
<div class="SongsContainer" style="clear:both;">
  <h2 class="arti">SONGS</h2>
  <div class="songs">
    <ul class="trackList">
    <?php
    $search = "$term%";
    $stmt  = $dbh->prepare("SELECT * FROM `songs` WHERE `title` LIKE ?");
    $stmt->execute([$search]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($data);

    if($stmt->rowCount() == 0) {
      echo "<span class='noResults'>No songs found matching</span>";
    }
    else {
      $i=1;
      //$album = new Artist($dbh, $artistId);
      $songsIdArray = $data;
      foreach ($songsIdArray as $song) {
        $nameArtist = new Artist($dbh, $song['artist']);
        //var_dump($nameArtist->getArti());
        if($i>10) break;
        echo "<li class='trackListRow'>
             <div class='trackCount'>
                 <img class='play' src='assests/images/icons/playSong.png' onclick='setTracks(\"".$song['id']."\", tempPlayList, true)'>
                 <span class='trackNumber'>".$i."</span>
             </div>

             <div class='trackInfo'>
             <span class='trackName'>".$song['title']."</span>"
             ." <span class='trackName'>".$nameArtist->getArti()[0]['name']."</span>"
             ." </div>

             <div class='trackOptions'>
                <input type='hidden' class='songId' value='" . $song['id'] . "'>
                <img class='optionsButton' src='assests/images/icons/more.png' onclick='showOptionsMenu(this)'>
             </div>

             <div class='trackDuration'>
             <span class='duration'>".$song['duration']."</span>".
            "</div></li>";
        $i++;
      }}

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
<hr style="width: 651px; color:red; height:0.1px; margin-top:10px;">
<div class="artistContainer">
  <h2 class="arti"> ARTIST </h2>
  <?php


    $search = "$term%";
    $artistQuery  = $dbh->prepare("SELECT * FROM `artist` WHERE `name` LIKE ?");
    $artistQuery->execute([$search]);
    $data = $artistQuery->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($data);
    if($artistQuery->rowCount() == 0) {
      echo "<span class='noResults'>No artists found matching</span>";
    }
    else {
      $i=1;
      $songsIdArray = $data;
      foreach ($songsIdArray as $song) {
      //  var_dump($song);
        $namesArtist = new Artist($dbh, $song["id"]);
        if($i>10) break;
        echo "<div class='searchResultRow'>
        <div class='artistName'>
          <span role='link' tabindex=0 onclick='openPage(\"artist.php?id=".$namesArtist->getId()."\")'>
            "
            . $namesArtist->getArti()[0]['name'].
            "
          </span>
          </div>
        </div>
        ";
      }
    }

  ?>

</div>

<hr style="width: 651px;">
<div class="gridViewContainer">
<h2 class="arti">ALBUMS</h2>
  <?php

     $sear = "$term%";
     $sql = "SELECT * FROM `albums` WHERE `title` LIKE ?";
     $query= $dbh->prepare($sql);
     $query->execute([$sear]);
     $results = $query->fetchAll(PDO::FETCH_ASSOC);
     //var_dump($results);
     if($query->rowCount()==0) {
       echo "<span class='noResults'>No Albums found matching</span>";
     }
     else {
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
