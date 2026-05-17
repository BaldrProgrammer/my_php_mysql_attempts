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


// Kod produktu do usunięcia
$productCodeToDelete = 'S10_9999';

// 1. Przygotowanie
$sql = "DELETE FROM products WHERE productCode = ?";
$stmt = $mysqli->prepare($sql);

// 2. Binding
$stmt->bind_param("s", $productCodeToDelete);

// 3. Wykonanie
$stmt->execute();

// 4. Sprawdzenie, czy rekord został usunięty
$affected_rows = $stmt->affected_rows;
if ($affected_rows > 0) {
    echo "Usunięto produkt o kodzie: " . htmlspecialchars($productCodeToDelete);
} else {
    echo "Nie znaleziono produktu o kodzie " . htmlspecialchars($productCodeToDelete) . " do usunięcia.";
}
$stmt->close();

// Na koniec pracy z bazą danych zamknij połączenie
$mysqli->close();
?>