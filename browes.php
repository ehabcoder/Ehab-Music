<?php include("includes/includedFile.php");
// include("includes/header.php");
// include("includes/footer.php");
?>

  <h1 class="pageHeadingBig">You Might Also Like</h1>

  <div class="gridViewContainer">

    <?php
       $sql = "SELECT * FROM `albums` ORDER BY RAND() LIMIT 10";
       $query = $dbh->prepare($sql);
       $query->execute();
       $results = $query->fetchAll(PDO::FETCH_ASSOC);
       if($query->rowCount() > 0)
       {
         foreach($results as $result) {
           echo "<div class='new'> 
                  <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $result['id'] ."\")'>
                    <img src='" .$result['artWorkPath']. "'>" .
                    "<div class='gridViewInfo'>" . $result['title'] . "</div>
                    </span>" .
                        "</div>";
         }
       }
    ?>
  </div>
