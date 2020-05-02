
let currentPlaylist = [];
let shufflePlaylist = [];
let tempPlayList = [];
let audioElement;
let mouseDown = false;
let currentIndex = 0;
let repeat = false;
let shuffle = false;
let timer;
// console.log(tempPlayList);

//currentIndex = shufflePlaylist.findIndex(obj => obj.id === audioElement.currentlyPlaying.id);
//console.log(tempPlayList[0].id);
//console.log(userLoggedIn);



function playFirstSong() {
  setTracks(tempPlayList[0], tempPlayList, true);
}
$(window).scroll(function() {
  hideOptionsMenu();
});

$(document).on("change", "select.playlist", function() {
    let playlistId = $(this).val();
    let songId = $(this).prev(".songId").val();
    let fetch = $(this);
    $.post("includes/handlers/ajax/addToPlaylist.php", {playlistId: playlistId, songId: songId})
    .done(function(errors){
      if(errors!="") {
        alert(errors);
        return ;
      }
      hideOptionsMenu();
      fetch.val("");
    });
});

$(document).click(function(event) {
  let target = $(event.target);
  if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
      hideOptionsMenu();
  }

});
function deleteSongFromPlaylist(button, playlistId) {
  let songId = $(button).prevAll(".songId").val();

  $.post("includes/handlers/ajax/deleteFromPlaylis.php", {playlistId: playlistId, songId: songId})
  .done(function(error){
    if(error){
    alert(error);
    return ;
  }
  openPage("playlist.php?id="+playlistId);
  });
}
function hideOptionsMenu() {
  let menu = $(".optionsMenu");
  if(menu.css("display") != "none") {
    menu.css("display", "none");
  }
}

function showOptionsMenu(button) {
  let songId = $(button).prevAll(".songId").val();
  let menu = $(".optionsMenu");
  let menuWidth = menu.width();
  menu.find(".songId").val(songId);
  let scrollTop = $(window).scrollTop(); //distance from top window to top document
  let elementOffset = $(button).offset().top ; //distance from top document
  let top = elementOffset - scrollTop;
  let left = $(button).position().left;

  menu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline" });
}

function deletePlaylist(playlistId) {
  var prompt = confirm("Are you sure you want to delete this playlist ?");
  if(prompt) {
    $.post("includes/handlers/ajax/deletePlaylist.php", {playlistId: playlistId})
    .done(function(error) {
        if(error!="") {
        alert(error);
        return;
      }
      openPage("yourMusic.php");
  });
}
}

function createPlayList() {
  //console.log(userLoggedIn);
  let aler = prompt("Enter the  name of the new playList");
  if(alert!=null) {
    $.post("includes/handlers/ajax/createPlayList.php", {name: aler, user: userLoggedIn}).done(function(error){
      if (error != "") {
        alert(error);
        return;
      }

       openPage("yourMusic.php")
    });
  }

}

function openPage(url) {
  if(timer!=null) {
    clearTimeout(timer);
  }

  if(url.indexOf("?")== -1) {
    url = url + '?';
  }
  let  encodedUrl = encodeURI(url +"&userLoggedIn=" + userLoggedIn);

  $('#mainContent').load(encodedUrl);
  $("body").scrollTop(0);
  history.pushState(null, null, url);
}

function formatDuration(duration) {
  let time = Math.round(duration);
  let minutes = Math.floor(time/60);
  let seconds = time - (minutes * 60);
  extra = seconds < 10 ? "0":"";
  return minutes + ":" + extra + seconds;
}
function updataCurrentTime(audio) {
  $(".progressTime.current").text(formatDuration(audio.currentTime));
  $(".progressTime.remaining").text(formatDuration(audio.duration - audio.currentTime));

  let progress = audio.currentTime / audio.duration * 100;
  $(".progressBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
  let volum = audio.volume * 100;
  $(".volumeBar .progress").css("width", volum + "%");
}


function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("canplay", function() {
      let duration = formatDuration(this.duration);
      $(".progressTime.remaining").text(duration);
    })
    this.audio.addEventListener("timeupdate", function(){
      if(this.duration) {
      updataCurrentTime(this);
    }
  });
  this.audio.addEventListener("ended", function() {
    nextSong();
  });
    this.audio.addEventListener("volumechange", function(){
      updateVolumeProgressBar(this);
    });


    this.setTrack = function(track) {
      this.currentlyPlaying = track[0];
      this.audio.src = track[0].path;
    }

    this.play = function() {
      this.audio.play();
    }

    this.pause = function() {
      this.audio.pause();
    }

    this.setTime = function(seconds) {
      this.audio.currentTime = seconds;
    }


}

function updateEmail(emailClass) {
  let emailValue = $(emailClass).val();
  $.post("includes/handlers/ajax/updateEmail.php", {email: emailValue, user: userLoggedIn})
  .done(function(response) {
    $(".message").fadeIn(500);
    $(emailClass).nextUntil(".final").text(response);
    $(".message").fadeOut(5000);
  });

}

function updatePassword(oldPass, newPass1, newPass2) {
  let oldPassValue = $(oldPass).val();
  let newPass = $(newPass1).val();
  let newPassCon = $(newPass2).val();

  $.post('includes/handlers/ajax/updatePassword.php',
   {user: userLoggedIn, old: oldPassValue, new1: newPass, new2: newPassCon})
   .done(function(response) {
     $(newPass2).next().fadeIn(500);
     $(newPass2).next().text(response);
     $(newPass2).next().fadeOut(5000);
   })
}

function logout() {
  $.post('includes/handlers/ajax/logout.php', function() {
    location.reload();
  });
}
