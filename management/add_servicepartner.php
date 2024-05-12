<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

$name = $_POST['name'];
$tax_number = $_POST['tax_number'];
$address_id = $_POST['address_id'];
$isInternal = $_POST['isInternal'];

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO servicepartners (name, tax_number, address_id, isInternal) VALUES ('$name', '$tax_number', $address_id, $isInternal)";

if ($conn->query($sql) === TRUE) {
    echo "Neuer Servicepartner erfolgreich hinzugefügt";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
