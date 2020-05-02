<?php

class Album {
  private $con, $id, $title, $artistId, $genre, $artWorkPath;

  public function __construct($con, $id) {
    $this->id = $id;
    $this->con = $con;

    $sql = "SELECT * FROM `albums` WHERE `id` = :id";
    $query = $this->con->prepare($sql);
    $query->bindParam(':id', $tempId);
    $tempId = $this->id;
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    $this->title = $results[0]['title'];
    $this->artistId = $results[0]['artist'];
    $this->genre = $results[0]['genre'];
    $this->artWorkPath = $results[0]['artWorkPath'];

  }

  public function getTitle() {
    return $this->title;
  }

  public function getArtist() {
    $artist = new Artist($this->con, $this->artistId);
    return $artist->getName();
  }

  public function getGenre() {
    return $this->genre;
  }

  public function getArtWorkPath() {
    return $this->artWorkPath;
  }

  public function getNumberOfSongs() {
    $sql = "SELECT `id` FROM `songs` WHERE `album`=:id";
    $songsQuery = $this->con->prepare($sql);
    $songsQuery->bindParam(':id', $iid);
    $iid = $this->id;
    $songsQuery->execute();
    return $songsQuery->rowCount();
  }

  public function getSongs() {
    $sql = "SELECT * FROM `songs` WHERE `album`=:id";
    $query = $this->con ->prepare($sql);
    $query->bindParam(':id', $iid);
    $iid = $this->id;
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getSongsids() {
    $sql = "SELECT `id` FROM `songs` WHERE `album`=:id";
    $query = $this->con ->prepare($sql);
    $query->bindParam(':id', $iid);
    $iid = $this->id;
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }
}

?>
