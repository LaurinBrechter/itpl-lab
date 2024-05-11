<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

$name = $_POST['name'];
$address_id = $_POST['address_id'];
$telephone_number = $_POST['telephone_number'];
$isVip = $_POST['isVip'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO customers (name, address_id, telephone_number, isVip) VALUES ('$name', $address_id, '$telephone_number', $isVip)";

if ($conn->query($sql) === TRUE) {
    echo "Neuer Kunde erfolgreich hinzugefügt";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
