<?php

class Artist {
  private $con, $id;

  public function __construct($con, $id) {
    $this->id = $id;
    $this->con = $con;
  }
  public function getName() {
    $sql = "SELECT `name` FROM `artist` WHERE `id` = (SELECT `artist` from `albums` WHERE `id`=:id)";
    $artistQuery = $this->con->prepare($sql);
    $artistQuery->bindParam(':id', $artistName);
    $artistName = $this->id;
    $artistQuery->execute();
    $artists = $artistQuery->fetchAll(PDO::FETCH_ASSOC);

    return $artists[0]['name'];
  }
  public function getNameForPlaylists() {
    $sql = "SELECT `name` FROM `artist` WHERE `id` = :id";
    $artistQuery = $this->con->prepare($sql);
    $artistQuery->bindParam(':id', $artistName);
    $artistName = $this->id;
    $artistQuery->execute();
    $artists = $artistQuery->fetchAll(PDO::FETCH_ASSOC);

    return $artists[0]['name'];
  }
  public function getSongsids() {
    $sql = "SELECT `id` FROM `songs` WHERE `artist`=:id ORDER BY plays DESC";
    $query = $this->con ->prepare($sql);
    $query->bindParam(':id', $iid);
    $iid = $this->id;
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getSongs() {
    $sql = "SELECT * FROM `songs` WHERE `album`=:id";
    $query = $this->con ->prepare($sql);
    $query->bindParam(':id', $iid);
    $iid = $this->id;
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
  }
  public function getArti() {
    $search = $this->id;
    $sql = $this->con->prepare("SELECT * FROM `artist` WHERE `id` = ?");
    $sql->execute([$search]);
    return $sql->fetchAll(PDO::FETCH_ASSOC);
  }
 public function getId() {
   return $this->id;
 }
}

?>
