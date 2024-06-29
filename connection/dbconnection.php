<?php

$dbhost = "localhost";
$dbuser = "softwareroot";
$dbpass = "";
$dbname = "madeups";

if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die("failed to connect!");
}
