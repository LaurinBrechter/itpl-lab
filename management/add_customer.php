<?php
include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

// Daten aus dem Formular empfangen
$name = $_POST['name'];
$telephone_number = $_POST['telephone_number'];
$isVip = $_POST['isVip'];
$street = $_POST['street'];
$house_number = $_POST['house_number'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$country = $_POST['country'];

// Adresse in die Datenbank einfügen
$sql = "INSERT INTO addresses (street, house_number, city, state, zip, country) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $street, $house_number, $city, $state, $zip, $country);
$stmt->execute();
$address_id = $stmt->insert_id; // Die ID der gerade eingefügten Adresse erhalten

// Kunden in die Datenbank einfügen
$sql = "INSERT INTO customers (name, address_id, telephone_number, isVip) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisi", $name, $address_id, $telephone_number, $isVip);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Neuer Kunde erfolgreich hinzugefügt.";
} else {
    echo "Fehler beim Hinzufügen des Kunden: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
