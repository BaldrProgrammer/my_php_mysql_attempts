<?php
$host = '127.0.0.1';
$db_user = 'admin';
$db_password = 'admin';
$db_name = 'classicmodels'; // Nazwa bazy danych

$mysqli = new mysqli($host, $db_user, $db_password, $db_name, 3306);
if ($mysqli->connect_error){
    die("bled podlaczenia" . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

$customerName = $_POST['customerName'];
$contactFirstName = $_POST['contactFirstName'];
$contactLastName = $_POST['contactLastName'];
$phone = $_POST['phone'];
$addressLine1 = $_POST['addressLine1'];
$city = $_POST['city'];
$country = $_POST['country'];

$sql = 'INSERT INTO customers (curtomerName, contactLastName, contactFirstName, phone, addressLine1, city, country) VALUES (? ? ? ? ? ? ?);';
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('sssssss', $customerName, $contactLastName, $contactFirstName, $phone, $addressLine1, $city, $country);

if ($stmt->execute()) {
    echo "Pomyślnie dodano nowy produkt o kodzie: " . htmlspecialchars($mysqli->insert_id);
} else {
    echo "Błąd podczas dodawania produktu: " . $stmt->error;
}
?>

<div class="example-form">
    <h3>Przykładowy formularz dodawania klienta</h3>
    <form method="POST" action="#">
        <div class="form-row">
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
                    <option value="USA">Ukraina</option>
                    <option value="Poland">Polska</option>
                    <option value="Germany">Niemcy</option>
                    <option value="Germany">Czechy</option>
                    <option value="Germany">Slowacja</option>
                    <option value="Germany">Litwa</option>
                </select>
            </div>
        </div>

        <button type="submit" style="background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
            Dodaj klienta
        </button>
    </form>
</div>