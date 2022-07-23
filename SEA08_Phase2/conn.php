<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$hostname = "127.0.0.1";
$db = "ProjectDB";
$username = "root";
$pwd = "";

function getDBconnection(){
    global $hostname, $username, $pwd, $db;
    $conn = mysqli_connect($hostname,$username,$pwd,$db)
    or die(mysqli_connect_error());
    return $conn;
}
?>