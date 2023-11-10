<?php
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $class_name = $_POST["class_name"];

  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
  $python = shell_exec("which python");
  $command = escapeshellcmd('$python execute_excel.py '.$target_file." ".$class_name);
  $out = shell_exec($command);

  echo ($out);



?>