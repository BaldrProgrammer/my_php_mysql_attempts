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


$productLine = 'Motorcycles';

// 1. Przygotowanie zapytania
$sql = "SELECT productCode, productName, buyPrice, quantityInStock FROM products WHERE productLine = ?";
$stmt = $mysqli->prepare($sql);

// 2. Powiązanie parametru ("s" -> string)
$stmt->bind_param("s", $productLine);

// 3. Wykonanie
$stmt->execute();

// 4. Pobranie wyników
$result = $stmt->get_result();

// 5. Przetwarzanie wyników
if ($result->num_rows > 0) {
    echo "<h3>Produkty z linii: " . htmlspecialchars($productLine) . "</h3>";
    echo "<table>";
    echo "<tr><th>Kod</th><th>Nazwa</th><th>Cena</th><th>Ilość w magazynie</th></tr>";
    while ($product = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($product['productCode']) . "</td>";
        echo "<td>" . htmlspecialchars($product['productName']) . "</td>";
        echo "<td>" . htmlspecialchars($product['buyPrice']) . "</td>";
        echo "<td>" . htmlspecialchars($product['quantityInStock']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Brak produktów w tej linii produkcyjnej.";
}
$stmt->close();
?>