<?php
    header('Content-Type: application/json');
    $myfile = fopen("class_name.txt", "r") or die("Unable to open file!");
    $class_name= fread($myfile,filesize("class_name.txt"));
    fclose($myfile);

    echo json_encode($class_name);
?>  