<?php
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $class_name = $_POST["class_name"];

  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }

  $command = escapeshellcmd('python execute_excel.py '.$target_file." ".$class_name);
  $out = shell_exec($command);

  $myfile = fopen("creatable_script.txt", "r") or die("Unable to open file!");
  $creatable_script = fread($myfile,filesize("creatable_script.txt"));
  fclose($myfile);
  
  // echo ($creatable_script);

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

  $sql = $creatable_script;

  if ($conn->query($sql) === TRUE) {
    echo "Table $class_name created successfully";
  } else {
    echo "Error creating table: " . $conn->error;
  }
  $conn->query("drop table $class_name");  // use for debug

  $conn->close();

  shell_exec("rm -rf creatable_script.txt");
?>