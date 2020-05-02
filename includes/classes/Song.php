<?php

class Song {
  private $con, $id;
  private $title, $artistId, $albumId, $genre, $duration, $path, $plays;

  public function __construct($con, $id) {
    $this->id = $id;
    $this->con = $con;

    $sql = "SELECT * FROM `songs` WHERE `album` = :id";
    $query = $this->con->prepare($sql);
    $query->bindParam(':id', $tempId);
    $tempId = $this->id;
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    $this->title = $results[0]['title'];
    $this->artistId = $results[0]['artist'];
    $this->albumId = $results[0]['album'];
    $this->genre = $results[0]['genre'];
    $this->duration = $results[0]['duration'];
    $this->path = $results[0]['path'];
    $this->plays = $results[0]['plays'];

  }


  public function getTitle() {
    return $this->title;
  }
  public function getArtist() {
    return (new Artist($this->con, $this->id));
  }
  public function getAlbum() {
    return new Album($this->con, $this->id);
  }
  public function getGenre() {
    return $this->genre;
  }
  public function getDuration() {
    return $this->duration;
  }
  public function getPath() {
    return $this->path;
  }
  public function getPlays() {
    return $this->plays;
  }
  
}
