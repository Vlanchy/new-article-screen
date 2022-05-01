<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "new_article_db";

try {
  $conn = new PDO("mysql:host=$server;dbname=$dbname", "$username", "$password");
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) 
{
  echo "Connection failed: " . $e->getMessage();
}
?>