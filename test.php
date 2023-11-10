<?php

 $myfile = fopen("data.txt", "r") or die("Unable to open file!");
 // Output one line until end-of-file
 while(!feof($myfile)) {
   echo fgets($myfile) ;
 }
 fclose($myfile);