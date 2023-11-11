<?php
$servername = "localhost";
$username = "admin";
$password = "123456";
$dbname = "DanhSachLop";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 


  $sql = "CREATE TABLE list_class(STT SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                  Class VARCHAR(255) NOT NULL)";
  $conn->query($sql);
  $sql = "SELECT Class FROM  list_class WHERE list_class.Class=$class_name";
  $check_exist_class = $conn->query($sql);
  if ($check_exist_class == Null) {
    $sql = "INSERT INTO list_class(Class) VALUES($class_name)";
    $conn->query($sql);
  }

 $conn->close();