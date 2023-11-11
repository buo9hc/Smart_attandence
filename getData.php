<?php
    header('Content-Type: application/json');
    include ("connect2server.php");

    $myfile = fopen("class_name.txt", "r") or die("Unable to open file!");
    $table_name= fread($myfile,filesize("class_name.txt"));
    fclose($myfile);

    $sql = "select * from "."$table_name";
    $result = $conn->query($sql);
    $data = array();

    foreach($result as $row){
        $data[]=$row;
    }
    
    $conn->close();
    echo json_encode($data);
?>