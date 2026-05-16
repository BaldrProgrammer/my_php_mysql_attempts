<?php
$host = '127.0.0.1';
$db_user = 'admin';
$db_password = 'admin';
$db_name = 'classicmodels'; // Nazwa bazy danych

$mysqli = new mysqli($host, $db_user, $db_password, $db_name, 3306);
if ($mysqli->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

// Metoda POST
$customerName = $_POST['customerName'];

// Metoda GET
$searchTerm = $_GET['search'];

// Bezpieczne pobieranie
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);


echo $customerName;
echo $searchTerm;
echo $city;
