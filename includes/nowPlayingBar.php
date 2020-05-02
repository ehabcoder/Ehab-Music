<?php
  $sql = "SELECT `id` FROM `songs` ORDER BY RAND() LIMIT 10";
  $songQuery = $dbh->prepare($sql);
  $songQuery->execute();
  $resultArray = $songQuery->fetchAll(PDO::FETCH_ASSOC);

  $jsonArray = json_encode($resultArray);
?>

<script>

  $(document).ready(function(){
    let nowPlaylist = <?php echo $jsonArray; ?>;
    audioElement = new Audio();
    setTracks(nowPlaylist[0]["id"], nowPlaylist, false);
    updateVolumeProgressBar(audioElement.audio);

    $("#nowPlayingBar").on("mousedown touchstart mousemove houchmove", function(event){
      event.preventDefault();
    });

    $(".playBackBar .progressBar").mousedown(function(){
      mouseDown = true;
    })
    $(".playBackBar .progressBar").mousemove(function(e){
      if(mouseDown) {
        //set time of song depending on position of mouse
        timeFromOffset(e, this);
      }
    });
    $(".playBackBar .progressBar").mouseup(function(event){
      timeFromOffset(event, this);
    });


    $(".volumeBar .progressVolBarBg").mousedown(function(){
      mouseDown = true;
    })
    $(".volumeBar .progressVolBarBg").mousemove(function(event){
      if(mouseDown){
            let persentage = event.offsetX / $(this).width();
            if(persentage>=0 && persentage<=1){
            audioElement.audio.volume = persentage;
            }
            if(audioElement.audio.volume===0) {
              setMute();
            }
  }});

  $(".volumeBar .progressVolBarBg").mouseup(function(event){
    let persentage = event.offsetX / $(this).width();
      if(persentage>=0 && persentage<=1){
        audioElement.audio.volume = persentage;
  }
  if(audioElement.audio.volume==0) {
    setMute();
  }
});

  $(document).mouseup(function() {
      mouseDown = false;
  });

  });

 /*function fill(old, newly) {
   for(let i=0; i<old.lenght; i++) {
     newly.push(old[i].id);
   }
 }*/

  function timeFromOffset(mouse, progressBar) {
    var persentage = mouse.offsetX / $(progressBar).width() * 100;
    var seconds = audioElement.audio.duration * (persentage/100);
    audioElement.setTime(seconds);
  }

  function previousSong() {
    console.log(currentIndex);

    if(repeat) {
      audioElement.setTime(0);
      playSong();
      return;
    }

    if(currentIndex == 0) {
      currentIndex = currentPlaylist.length-1;
    }
    else {
      currentIndex--;
    }
    let trackToPlay = currentPlaylist[currentIndex].id;
    setTracks(trackToPlay, currentPlaylist, true);
  }

  function setRepeat() {
    repeat = !repeat;
    let image = repeat ? "assests/images/icons/repeat/repeatActive.png" : "assests/images/icons/repeat/repeat.png";
    $(".controlButton.repeat img").attr("src", image);
  }

 function setMute() {
   audioElement.audio.muted = !audioElement.audio.muted;
   let image = audioElement.audio.muted ? "assests/images/icons/volume/mute.png":"assests/images/icons/volume/volume.png";
   $(".controlButton.volume img").attr("src", image);
 }

function setShuffle() {
  shuffle = !shuffle;
  let image = shuffle ? "assests/images/icons/shuffle/shuffleActive.png" : "assests/images/icons/shuffle/shuffle.png";
  $(".controlButton.shuffle img").attr("src", image);

  if(shuffle) {
    // Randomize playList
    randomize(shufflePlaylist);
    currentIndex = shufflePlaylist.findIndex(obj => obj.id === audioElement.currentlyPlaying.id);
  }
  else {
    // Shufle has been deactivated, go back to regular playlist
    currentIndex = currentPlaylist.findIndex(obj => obj.id === audioElement.currentlyPlaying.id);
  }
}
///the suffle function
/*function shuffle(sourceArray) {
    for (var i = 0; i < sourceArray.length - 1; i++) {
        var j = i + Math.floor(Math.random() * (sourceArray.length - i));

        var temp = sourceArray[j];
        sourceArray[j] = sourceArray[i];
        sourceArray[i] = temp;
    }
    return sourceArray;
}*/
function randomize(currentList) {
  for(let i=0; i<currentList.length-1; i++) {
    let j = i + Math.floor(Math.random() * (currentList.length - i));
    let temp = currentList[j].id;
    currentList[j].id = currentList[i].id;
    currentList[i].id = temp;
  }
  return currentList;
}

function nextSong() {
  console.log(currentIndex);
  if(repeat) {
    audioElement.setTime(0);
    playSong();
    return;
  }
  //console.log(currentIndex);
  if(currentIndex == currentPlaylist.length-1) {
    currentIndex = 0;
  }
  else {
    currentIndex += 1;
  }
 let trackToPlay = currentPlaylist[currentIndex].id;
 // console.log(trackToPlay);
  setTracks(trackToPlay, currentPlaylist, true);
}

function setTracks(trackId, newPlayList, play) {
      console.log(currentIndex);
      if(newPlayList != currentPlaylist) {
        currentPlaylist = newPlayList;
        shufflePlaylist = currentPlaylist.slice();
        //randomize(shufflePlaylist);
      }
      if(shuffle) {
        currentIndex = shufflePlaylist.findIndex(obj => obj.id === trackId);
      }
     else {
       currentIndex = currentPlaylist.findIndex(obj => obj.id === trackId);
     }
     //pauseSong();
      $.post("includes/handlers/ajax/getSongjson.php", { songId: trackId }, function(data) {
        let track = JSON.parse(data);
        $(".trackName span").text(track[0].title);
      $.post("includes/handlers/ajax/getArtistjson.php", {artistId: track[0].artist}, function(data) {
          let artist = JSON.parse(data);
          //console.log(artist);
          $(".artistName span").text(artist[0].name);
          $(".artistName span").attr("onclick", "openPage('artist.php?id=" + artist[0].id +"')");
      });
      $.post("includes/handlers/ajax/getAlbumJson.php", {albumId: track[0].album}, function(data) {
        let art = JSON.parse(data);
        //console.log(art);
        $(".albumLink .albumArtWork").attr('src', art[0].artWorkPath);
        $(".albumLink .albumArtWork").attr("onclick", "openPage('album.php?id=" + art[0].id +"')");
        $(".trackName span").attr("onclick", "openPage('album.php?id=" + art[0].id +"')");
      });
      audioElement.setTrack(track);
      if(play) {
        playSong();
      }
  });


}



function findIndex(trackId) {
  for(i=0; i<currentPlaylist.length; i++) {
    if(currentPlaylist.id == trackId) {
      return currentPlaylist.id;
    }
  }
}
  function playSong() {

   if(audioElement.audio.currentTime==0) {
      iid = audioElement.currentlyPlaying.id;
      $.post("includes/handlers/ajax/updatePlays.php", {songId: iid});
    }

    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
  }

  function pauseSong() {
    $(".controlButton.play").show();
    $(".controlButton.pause").hide();

    audioElement.pause();
  }

</script>

<div id="nowPlayingBar">
  <div id="nowPlayingLeft">
    <div class="content">
    <span class="albumLink">
        <img role="link" tabindex="0"  src="" class="albumArtWork">
    </span>
    <div class="trackInfo">

      <span class="trackName">
        <span role="link" tabindex="0"> </span>
       </span>

       <span class="artistName">
         <span role="link" tabindex="0"></span>
        </span>

    </div>
  </div>
  </div>
  <div id="nowPlayingCenter">
    <div class="content playerControls">
      <div class="buttons">
        <button class="controlButton shuffle" title="shuffle button" onclick="setShuffle()">
          <img src="assests/images/icons/shuffle/shuffle.png" alt="Shuffle">
        </button>
        <button class="controlButton previous" title="previous button" onclick="previousSong()">
          <img src="assests/images/icons/previous.png" alt="Previous">
        </button>
        <button class="controlButton play" title="play button" onclick="playSong()">
          <img src="assests/images/icons/play.png" alt="Play">
        </button>
        <button class="controlButton pause" title="pause button" style="display:none;" onclick="pauseSong()">
          <img src="assests/images/icons/pause.png" alt="Pause">
        </button>
        <button class="controlButton next" title="next button" onclick="nextSong()">
          <img src="assests/images/icons/next.png" alt="Next">
        </button>
        <button class="controlButton repeat" title="repeat button" onclick="setRepeat()">
          <img src="assests/images/icons/repeat/repeat.png" alt="Repeat">
        </button>
      </div>

      <div class="playBackBar">

        <span class="progressTime current">0.00</span>

        <div class="progressBar">
          <div class="progressBarBg">
            <div class="progress"></div>
        </div>
      </div>

        <span class="progressTime remaining">0.00</span>
    </div>
</div>
</div>

<div id="nowPlayingRight">
<div class="volumeBar">
  <button class="controlButton volume" title="volume button" onclick="setMute()">
    <img src="assests/images/icons/volume/volume.png" alt="volume">
  </button>
  <div class="progressVolBar">
    <div class="progressVolBarBg">
      <div class="progress"></div>
    </div>
  </div>
</div>
</div>
</div>
