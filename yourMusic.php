<?php
include("includes/includedFile.php");
 ?>

 <div class="playListContainer">
   <div class="gridViewContainer">
     <h2 class="arti" style="font-size:20px; font-family:Arial, Helvetica, sans-serif; padding:10px;">PLAYLIST</h2>

    <div class="buttonItems">
        <button class="button green" onclick="createPlayList()">NEW PLAYLIST</button>
    </div>

    <?php
       $username = $userLoggedIn->getUsername();
       $sql = "SELECT * FROM `playList` WHERE `owner` = ?";
       $query= $dbh->prepare($sql);
       $query->execute([$username]);
       $results = $query->fetchAll(PDO::FETCH_ASSOC);
       //var_dump($results);
       if($query->rowCount()==0) {
         echo "<span class='noResults'>No Playlists was created yet</span>";
       }
       else {
         foreach($results as $result) {
           //var_dump($result);
           $playlist = new Playlist($dbh,  $result);
           echo "<div class='gridViewItem' role='link' tapindex='0' onclick='openPage(\"playlist.php?id=". $playlist->getId() ."\")'>
           <div class='playListImage'>
              <img src='assests/images/icons/playList.png'>
           </div>
           <div class='gridViewInfo'>"
           . $playlist->getName() .
           "</div>

            </div>";

         }
       }


    ?>

   </div>
 </div>
