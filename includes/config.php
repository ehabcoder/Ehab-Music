<?php
 ob_start();
 session_start();
 $timezone = date_default_timezone_set("Africa/Cairo");


  define("DB_HOST", "localhost:3306");
  define("DB_USER", "root");
  define("DB_PASS", "");
  define("DB_NAME", "ehapofy");

  try
  {
    $dns = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
    $dbh = new PDO($dns, DB_USER, DB_PASS);
  }
  catch(PDOException $e)
  {
    exit("Error: ". $e->getMessage());
  }

// $sql = "INSERT INTO `users` (`username`, `firstName`)
//         values(:name, :nam)";
//
// $query = $dbh->prepare($sql);
// $query->bindParam(':name', $name, PDO::PARAM_STR);
// $query->bindParam(':nam', $nam, PDO::PARAM_STR);
// $name = "ehab";
// $nam = "reda";
// $query->execute();

 ?>
