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


// Dane do aktualizacji
$productCodeToUpdate = 'S18_1749';
$newPrice = 99.99;
$newStock = 500;

// 1. Przygotowanie
$sql = "UPDATE products SET buyPrice = ?, quantityInStock = ? WHERE productCode = ?";
$stmt = $mysqli->prepare($sql);

// 2. Powiązanie parametrów ("dis" -> double, integer, string)
$stmt->bind_param("dis", $newPrice, $newStock, $productCodeToUpdate);

// 3. Wykonanie
$stmt->execute();

// 4. Sprawdzenie liczby zaktualizowanych wierszy
$affected_rows = $stmt->affected_rows;
if ($affected_rows > 0) {
    echo "Zaktualizowano dane produktu o kodzie: " . htmlspecialchars($productCodeToUpdate);
} else {
    echo "Nie dokonano zmian. Produkt o podanym kodzie nie istnieje lub dane są takie same.";
}
$stmt->close();
?>