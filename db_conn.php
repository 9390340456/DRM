<?php

$db_name = "drm_db";
$sname = "localhost";
$uid = "root";
$password = "";
 
$conn = mysqli_connect($sname, $uid, $password, $db_name);
if(!$conn) {
    echo "connection Failed";
}
