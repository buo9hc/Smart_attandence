<?php
    header('Content-Type: application/json');
    $date_time_file = "datetime.txt";
    $line = file($date_time_file);
    $time_start = strtotime($line[1]);
    $time_start = date("h:i:sa", $time_start);
    $time_end = strtotime($line[2]);
    $time_end = date("h:i:sa", $time_end);

    $class_time = array();
    $class_time[0] = $time_start;
    $class_time[1] = $time_end;
    echo json_encode($class_time);
?>  