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


// Dane nowego produktu
$productCode = 'S10_9999';
$productName = 'Nowy Model Superauta';
$productLine = 'Classic Cars';
$productDescription = 'Replika w skali 1:10 z pełnym wyposażeniem.';
$quantityInStock = 150;
$buyPrice = 120.55;

// 1. Przygotowanie zapytania SQL z placeholderami (?)
$sql = "INSERT INTO products (productCode, productName, productLine, productDescription, quantityInStock, buyPrice) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);

// 2. Powiązanie parametrów (binding)
// "ssssid" -> string, string, string, string, integer, double
$stmt->bind_param("ssssid", $productCode, $productName, $productLine, $productDescription, $quantityInStock, $buyPrice);

// 3. Wykonanie zapytania
if ($stmt->execute()) {
    echo "Pomyślnie dodano nowy produkt o kodzie: " . htmlspecialchars($productCode);
} else {
    echo "Błąd podczas dodawania produktu: " . $stmt->error;
}

// 4. Uwaga: W tej tabeli nie ma auto-inkrementowanego ID, więc $mysqli->insert_id zwróci 0.
//    Sprawdzamy powodzenie operacji na podstawie wyniku metody execute().

// 5. Zawsze zamykaj instrukcję po jej użyciu
$stmt->close();
?>