<?php
  include("connect2server.php");

  /**
   * read file contain class name
   */
  $myfile = fopen("class_name.txt", "r") or die("Unable to open file!");
  $table_name= fread($myfile,filesize("class_name.txt"));
  fclose($myfile);
  /**
   * process date&time
   */
  $date_time_file = "datetime.txt";
  $line = file($date_time_file);
  $startDate = strtotime($line[0]);
  $endDate = strtotime("+ 15 weeks", $startDate);
  $Weeks = array();

  $time_codition = strtotime($line[1]);
  $time_codition = strtotime("- 30 minutes 0 seconds",$time_codition);
  $time_codition = date("H:i:s",$time_codition);
  $time_start = strtotime($line[1]);
  $time_start = date("H:i:s", $time_start);
  $time_end = strtotime($line[2]);
  $time_end = date("H:i:s", $time_end);
  // echo $time_codition."\n";
  // echo $time_start."\n";
  // echo $time_end."\n";

  $n = 0;
  while($startDate < $endDate){
    $Weeks[$n] = date("y-m-d",$startDate);
    $n +=1;
    $startDate = strtotime("+ 1 week", $startDate);
  }
  /**
   * check and delete old data
   */
  $today = date("y-m-d");
  $sql = "SELECT Date FROM attendance_check";
  $result = $conn->query($sql);
  $check_old_day_data = array();
  $check =0;
  while($data_check = mysqli_fetch_assoc($result)){
    $check_old_day[$check] = $data_check["Date"];
    $check +=1;
  }

  for ($i=0; $i < $check; $i++) { 
    $check_old_day_data = $check_old_day[$i];
    $old_day = strtotime($check_old_day[$i]);
    $old_day = date("y-m-d", $old_day);
    $early_time = strtotime($check_old_day[$i]);
    $early_time = date("H:i:s", $early_time);
    if ($old_day<$today || $early_time < $time_codition) {
      $sql = "DELETE FROM attendance_check WHERE Date='$check_old_day_data'";
      $result = $conn->query($sql);
    }
  }
  /**
   * update date time into main database
   */
  $sql = "SELECT COUNT(TT) FROM $table_name";
  $result = $conn->query($sql);
  $count = mysqli_fetch_assoc($result);
  for ($i=1; $i <= $count["COUNT(TT)"] ; $i++) { 
    $sql = "SELECT Ma_SV FROM $table_name WHERE TT=$i";
    $result = $conn->query($sql);
    $Ma_SV = mysqli_fetch_assoc($result);
    $Ma_SV = $Ma_SV["Ma_SV"];

    $sql = "SELECT MIN(Date) FROM attendance_check WHERE SID=$Ma_SV";
    $result = $conn->query($sql);
    $atDateTime = mysqli_fetch_assoc($result);
    $atDateTime = $atDateTime["MIN(Date)"];
    $atDate = strtotime($atDateTime);
    $atDate = date("y-m-d", $atDate);
    $atTime = strtotime($atDateTime);
    $atTime = date("H:i:s",$atTime);
    if ($atDateTime!=Null && $atTime > $time_codition && $atTime < $time_end) {
      // echo $atTime."\n";
      switch ($atDate) {
        case $Weeks[0]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_1='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_1='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[1]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_2='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_2='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[2]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_3='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_3='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[3]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_4='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_4='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[4]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_5='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_5='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[5]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_6='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_6='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[6]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_7='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_7='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[7]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_8='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_8='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[8]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_9='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_9='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[9]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_10='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_10='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[10]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_11='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_11='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[11]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_12='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_12='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[12]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_13='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_13='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[13]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_14='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_14='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;
        case $Weeks[14]:
          if ($atTime > $time_codition && $atTime < $time_start) {
            $sql = "UPDATE $table_name SET Tuan_15='Đúng giờ' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          else {
            $sql = "UPDATE $table_name SET Tuan_15='$atTime' WHERE Ma_SV=$Ma_SV";
            $conn->query($sql);
          }
          break;                                                                                                                                                                                     
        default:
          break;
      }
    }
  }
 $conn->close();