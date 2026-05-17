<div class="example-form">
    <h3>Dodawanie klienta</h3>
    <form method="POST" action="#">
        <div class="form-row">
            <div class="form-group"> <!-- no kurde nie jest on autoincrement -->
                <label for="customerNumber">Numer klienta:</label>
                <input type="text" id="customerNumber" name="customerNumber" required="">
            </div>
            <div class="form-group">
                <label for="customerName">Imie:</label>
                <input type="text" id="customerName" name="customerName" required="">
            </div>
            <div class="form-group">
                <label for="contactFirstName">Imie kontaktowe:</label>
                <input type="text" id="contactFirstName" name="contactFirstName" required="">
            </div>
            <div class="form-group">
                <label for="contactLastName">Nazwisko kontaktowe:</label>
                <input type="text" id="contactLastName" name="contactLastName" required="">
            </div>
            <div class="form-group">
                <label for="phone">Numer telefonu:</label>
                <input type="text" id="phone" name="phone" required="">
            </div>
            <div class="form-group">
                <label for="addressLine1">Adres:</label>
                <input type="text" id="addressLine1" name="addressLine1" required="">
            </div>
            <div class="form-group">
                <label for="city">Miasto:</label>
                <input type="text" id="city" name="city" required="">
            </div>
            <div class="form-group">
                <label for="country">Kraj:</label>
                <select id="country" name="country" required="">
                    <option value="">Wybierz kraj</option>
                    <option value="Ukraine">Ukraina</option>
                    <option value="Poland">Polska</option>
                    <option value="Germany">Niemcy</option>
                    <option value="Czech">Czechy</option>
                    <option value="Slovakia">Slowacja</option>
                    <option value="Lithuania">Litwa</option>
                </select>
            </div>
        </div>

        <button type="submit" style="background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            Dodaj klienta
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

$customerNumber = $_POST['customerNumber'];
$customerName = $_POST['customerName'];
$contactFirstName = $_POST['contactFirstName'];
$contactLastName = $_POST['contactLastName'];
$phone = $_POST['phone'];
$addressLine1 = $_POST['addressLine1'];
$city = $_POST['city'];
$country = $_POST['country'];

$sql = 'INSERT INTO customers (customerNumber, customerName, contactLastName, contactFirstName, phone, addressLine1, city, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?);';
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('isssssss', $customerNumber, $customerName, $contactLastName, $contactFirstName, $phone, $addressLine1, $city, $country);

if ($stmt->execute()) {
    echo "Pomyslnie dodano nowy klient o kodzie: " . htmlspecialchars($mysqli->insert_id);
} else {
    echo "blas podczas dodawania klientu: " . $stmt->error;
}
?>