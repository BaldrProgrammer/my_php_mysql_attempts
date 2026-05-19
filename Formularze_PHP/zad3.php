<div class="example-form">
    <h3>Edycja produktu</h3>

    <form method="POST">

        <div class="form-row">

            <div class="form-group">
                <label for="productCode">Kod produktu:</label>
                <input type="text" id="productCode" name="productCode">
            </div>

            <div class="form-group">
                <label for="price">Nowa cena:</label>
                <input type="text" id="price" name="price">
            </div>

        </div>

        <button type="submit"
                style="background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            Zmien
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
    die("blad podlaczenia " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");

$productCode = $_POST['productCode'] ?? null;
$newPrice = $_POST['price'] ?? null;

if ($productCode && $newPrice){

    $tries = 0;

    while ($tries < 3){

        try {

            $mysqli->begin_transaction();

            /*
             * blokowanie produktu
             */
            $sql = "
                SELECT *
                FROM products
                WHERE productCode = ?
                FOR UPDATE
            ";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $productCode);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows == 0){
                throw new Exception("Produkt nie istnieje");
            }

            $product = $result->fetch_assoc();

            /*
             * sprawdzenie ilosci
             */
            if ($product['quantityInStock'] <= 0){
                throw new Exception("Brak produktu");
            }

            /*
             * update ceny
             */
            $sql = "
                UPDATE products
                SET buyPrice = ?
                WHERE productCode = ?
            ";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ds", $newPrice, $productCode);
            $stmt->execute();

            /*
             * historia + statystyki
             */
            $multi = "
                INSERT INTO product_history(productCode, oldPrice, newPrice)
                VALUES(
                    '$productCode',
                    '{$product['buyPrice']}',
                    '$newPrice'
                );

                UPDATE product_stats
                SET updatedProducts = updatedProducts + 1
                WHERE productLine = '{$product['productLine']}'
            ";

            $mysqli->multi_query($multi);

            while ($mysqli->next_result()){
                ;
            }

            $mysqli->commit();

            echo "<p>Produkt zostal zmieniony</p>";

            break;

        } catch (mysqli_sql_exception $e){

            $mysqli->rollback();

            /*
             * deadlock retry
             */
            if ($e->getCode() == 1213){

                $tries++;

                sleep(1);

                continue;
            }

            echo "<p>MYSQL ERROR: " . $mysqli->error . "</p>";

            echo "<pre>";
            print_r($mysqli->error_list);
            echo "</pre>";

            break;

        } catch (Exception $e){

            $mysqli->rollback();

            echo "<p>" . $e->getMessage() . "</p>";

            break;
        }
    }
}

?>