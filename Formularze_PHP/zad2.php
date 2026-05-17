<div class="example-form">
    <h3>Wyswietlenie zamowienia za jego numerem</h3>
    <form method="GET">
        <div class="form-row">
            <div class="form-group">
                <label for="orderNumber">Prosze podac Numer Zamowienia:</label>
                <input type="text" id="orderNumber" name="orderNumber" required="">
            </div>
        </div>
        <button type="submit" style="background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            Wyswietl
        </button>
    </form>
</div>


<?php
$host = '127.0.0.1';
$db_user = 'admin';
$db_password = 'admin';
$db_name = 'classicmodels';

$mysqli = new mysqli($host, $db_user, $db_password, $db_name, 3306);
if ($mysqli->connect_error){
    die("blad podlaczenia" . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");


$orderNumber = $_GET['orderNumber'];

$sql = 'SELECT * FROM orders WHERE orderNumber = ?';
$stmt = $mysqli->prepare($sql);

$stmt->bind_param('i', $orderNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h3>Produkty z linii: " . htmlspecialchars($orderNumber) . "</h3>";
    echo "<table>";
    echo "<tr><th>order date</th><th>required date</th><th>shipped date</th><th>status</th>><th>comments</th></tr>";
    while ($order = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($order['orderNumber']) . "</td>";
        echo "<td>" . htmlspecialchars($order['orderDate']) . "</td>";
        echo "<td>" . htmlspecialchars($order['requiredDate']) . "</td>";
        echo "<td>" . htmlspecialchars($order['shippedDate']) . "</td>";
        echo "<td>" . htmlspecialchars($order['status']) . "</td>";
        echo "<td>" . htmlspecialchars($order['comments']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>