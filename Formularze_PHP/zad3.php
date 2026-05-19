<div class="example-form">
    <h3>Edycja produktu</h3>
    <form method="POST" action="#">
        <div class="form-row">
            <div class="form-group">
                <label for="productCode">Numer produktu:</label>
                <input type="text" id="productCode" name="productCode" required="">
            </div>
            <div class="form-group">
                <label for="msrp">Nowa cena:</label>
                <input type="text" id="msrp" name="msrp" required="">
            </div>
            <div class="form-group">
                <label for="productLine">Linia produktu:</label>
                <input type="text" id="productLine" name="productLine" required="">
            </div>
        </div>
        <button type="submit" style="background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            Zapisz zmiany
        </button>
    </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mysqli = new mysqli('127.0.0.1', 'admin', 'admin', 'classicmodels', 3306);
    if ($mysqli->connect_error) {
        die("Blad podlaczenia: " . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8mb4");

    $productCode = $_POST['productCode'];
    $msrp = $_POST['msrp'];
    $productLine = $_POST['productLine'];

    $maxRetries = 3;
    $isUpdated = false;

    while ($maxRetries > 0 && !$isUpdated) {
        $mysqli->begin_transaction();

        try {
            $stmt = $mysqli->prepare("SELECT MSRP, productDescription FROM products WHERE productCode = ? FOR UPDATE");
            $stmt->bind_param("s", $productCode);
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if (!$product) {
                throw new Exception("Produkt nie istnieje");
            }

            $oldPrice = $product['MSRP'];
            $newDescription = $product['productDescription'] . " [Log: zmiana ceny z {$oldPrice} na {$msrp}]";

            $escapedProductCode = $mysqli->real_escape_string($productCode);
            $escapedProductLine = $mysqli->real_escape_string($productLine);
            $escapedDescription = $mysqli->real_escape_string($newDescription);

            $sql = "
                UPDATE products 
                SET MSRP = {$msrp}, productDescription = '{$escapedDescription}' 
                WHERE productCode = '{$escapedProductCode}';
                
                UPDATE productlines 
                SET textDescription = CONCAT('Suma MSRP dla tej kategorii: ', (SELECT SUM(MSRP) FROM products WHERE productLine = '{$escapedProductLine}')) 
                WHERE productLine = '{$escapedProductLine}';
            ";

            if (!$mysqli->multi_query($sql)) {
                $errors = current($mysqli->error_list);
                throw new Exception($errors['error'] ?? $mysqli->error, $mysqli->errno);
            }

            do {
                if ($result = $mysqli->store_result()) {
                    $result->free();
                }
            } while ($mysqli->more_results() && $mysqli->next_result());

            $mysqli->commit();
            $isUpdated = true;
            echo "Pomyslnie zaktualizowano produkt i statystyki linii";

        } catch (Exception $e) {
            $mysqli->rollback();

            if ($e->getCode() == 1213) {
                $maxRetries--;
                usleep(50000);
                if ($maxRetries == 0) {
                    echo "Blad blokady bazy danych: " . $e->getMessage();
                }
            } else {
                echo "Blad podczas edycji: " . $e->getMessage();
                break;
            }
        }
    }
    $mysqli->close();
}
?>