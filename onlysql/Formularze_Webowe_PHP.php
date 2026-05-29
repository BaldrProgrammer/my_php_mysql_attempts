<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "classicmodels";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn){
    die('blad polaczenia' . mysqli_connect_error());
}


$orderNumber = rand(0, 999999);
$orderDate = $_POST['orderDate'];
$requiredDate = $orderDate + 7;
$shippedDate = $requiredDate + 7;
$status = $_POST['status'];
$comments = "";
$customerNumber = $_POST['customerNumber'];
