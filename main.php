<form method="POST" action="#">
    <div class="form-row">
        <div class="form-group">
            <label for="customerName">Nazwa klienta:</label>
            <input type="text" id="customerName" name="customerName" required="">
        </div>
        <div class="form-group">
            <label for="contactLastName">Nazwisko kontaktowe:</label>
            <input type="text" id="contactLastName" name="contactLastName" required="">
        </div>
    </div>

    <div class="form-group">
        <label for="addressLine1">Adres:</label>
        <input type="text" id="addressLine1" name="addressLine1" required="">
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="city">Miasto:</label>
            <input type="text" id="city" name="city" required="">
        </div>
        <div class="form-group">
            <label for="country">Kraj:</label>
            <select id="country" name="country" required="">
                <option value="">Wybierz kraj</option>
                <option value="USA">USA</option>
                <option value="Poland">Polska</option>
                <option value="Germany">Niemcy</option>
            </select>
        </div>
    </div>

    <button type="submit" style="background: #3498db; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
        Dodaj klienta
    </button>
</form>
<?php
$host = 'localhost';
$dbname = 'classicmodels';
$username = 'root';
$password = 'adminadmin';
$sql = "INSERT INTO customers (
  customerName, contactLastName, contactFirstName,
  phone, addressLine1, city, country
) VALUES (?, ?, ?, ?, ?, ?, ?)";

// Nawiązanie połączenia z MySQLi
$mysqli = new mysqli($host, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($mysqli->connect_error) {
    die("Błąd połączenia z bazą danych: " . $mysqli->connect_error);
}

// Ustawienie kodowania znaków
$mysqli->set_charset("utf8");

// Metoda POST
$customerName = $_POST['customerName'];
?>