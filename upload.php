
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Chua biet ten gi</title>
  </head>
  <body>
    <p><a href="uploadform.html">Cập nhật danh sách thành công</a></p>
  </body>
</html>


<?php
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $class_name = $_POST["class_name"];

  move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

  $command = escapeshellcmd('python execute_excel.py '.$target_file." ".$class_name);
  $out = shell_exec($command);

  $myfile = fopen("creatable_script.txt", "r") or die("Unable to open file!");
  $creatable_script = fread($myfile,filesize("creatable_script.txt"));
  fclose($myfile);
  
  $servername = "localhost";
  $username = "admin";
  $password = "123456";
  $dbname = "DanhSachLop";
  
  /*
   Create connection
   */
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 

  /*
   create class table
   */
  $sql = $creatable_script;
  $conn->query($sql);
 
  /*
   instert data to table 
   */
  $myfile = fopen("data.txt", "r") or die("Unable to open file!");
  // Output one line until end-of-file
  while(!feof($myfile)) {
    $sql = fgets($myfile) ;
    if ($sql != Null) {
      $conn->query($sql);
    }
  }
  fclose($myfile);
  
  $conn->close();
  
  shell_exec("rm creatable_script.txt");
  shell_exec('rm data.txt');
  // shell_exec("rm -rf /var/www/html/uploads/*"); // use for debug



?>

