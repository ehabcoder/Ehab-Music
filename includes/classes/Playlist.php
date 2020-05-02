<?php
  class Playlist {

    private $con, $name, $owner, $id;

    public function __construct($con, $data) {

      if(!is_array($data)) {
        $sql = "SELECT * FROM `playlist` WHERE `id` = :id";
        $query = $con->prepare($sql);
        $query->bindParam(':id', $iid, PDO::PARAM_INT);
        $iid = $data;
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $this->con = $con;
        $this->id = $data[0]['id'];
        $this->name = $data[0]['name'];
        $this->owner = $data[0]["owner"];
         //var_dump($data);
        // echo $data['id'];
      }
      else {
        $this->con = $con;
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->owner = $data["owner"];
      }



    }

    public function getName() {
      return $this->name;
    }
    public function getId() {
      return $this->id;
    }
    public function getOwner() {
      return $this->owner;
    }
    public function getNumberOfSongs() {
      $sql = "SELECT `songId` FROM `playlistsongs` WHERE `playlistId`=:id";
      $query = $this->con->prepare($sql);
      $query->bindParam(':id', $iid, PDO::PARAM_INT);
      $iid = $this->id;
      $query->execute();
      return $query;
    }
    public function getSongs() {
      $sql = "SELECT * FROM `playlistsongs` WHERE `playlistId`=:id";
      $query = $this->con ->prepare($sql);
      $query->bindParam(':id', $iid);
      $iid = $this->id;
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSongsId() {
      $sql = "SELECT `songId` as id FROM `playlistsongs` WHERE `playlistId`=:id";
      $query = $this->con ->prepare($sql);
      $query->bindParam(':id', $iid);
      $iid = $this->id;
      $query->execute();
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPlaylistDropdown($con, $username) {
      $dropdown = "<select class='item playlist'>
                    <option value=''>Add to playlist</option>";
      $query = $con->prepare("SELECT `id`, `name` FROM `playlist` WHERE `owner`=?");
      $query->execute([$username]);
      $results = $query->fetchAll(PDO::FETCH_ASSOC);
      foreach ($results as $res) {
        $id = $res['id'];
        $name = $res['name'];
        $dropdown = $dropdown . "<option value='$id'>$name</option>";
      }
      return $dropdown . "</select>";
    }

  }

 ?>
