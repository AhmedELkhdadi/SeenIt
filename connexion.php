<?php
function connectdb()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "seenit";

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db) or die("error");
    return $conn;
}
