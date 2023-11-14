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


  $sql = "SELECT COUNT(TT) FROM Class_IoT";
  $result = $conn->query($sql);
  $count = mysqli_fetch_assoc($result);
for ($i=1; $i <= $count["COUNT(TT)"] ; $i++) { 
  $sql = "SELECT Ma_SV FROM Class_IoT WHERE TT=$i";
  $result = $conn->query($sql);
  $Ma_SV = mysqli_fetch_assoc($result);
  $Ma_SV = $Ma_SV["Ma_SV"];

  $sql = "SELECT MIN(atendance_time) FROM atendence_time WHERE SID=$Ma_SV";
  $result = $conn->query($sql);
  $atTime = mysqli_fetch_assoc($result);
  $atTime = $atTime["MIN(atendance_time)"];
  if ($atTime!=Null) {
    # code...
    $sql = "UPDATE Class_IoT SET Tuan_6='$atTime' WHERE Ma_SV=$Ma_SV";
    $conn->query($sql);
  }
  // echo $atTime."\n";
  // echo $Ma_SV."\n";
}
  // echo $count["COUNT(TT)"];
 $conn->close();