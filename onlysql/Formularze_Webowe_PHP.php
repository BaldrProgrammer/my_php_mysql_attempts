<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn){
    die('blad polaczenia' . mysqli_connect_error());
}
