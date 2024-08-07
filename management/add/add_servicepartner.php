<?php
include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';

// Daten aus dem Formular empfangen
$name = $_POST['name'];
$tax_number = $_POST['tax_number'];
$isInternal = $_POST['isInternal'];
$street = $_POST['street'];
$house_number = $_POST['house_number'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$country = $_POST['country'];

// User in Datenbank anlegen
$sql = "INSERT INTO users (username, role) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$role = 'SERVICE_PARTNER';
$stmt->bind_param("ss", $name, $role);
$stmt->execute();
$user_id = $stmt->insert_id; // Die ID des gerade eingefügten Benutzers erhalten

// Adresse in die Datenbank einfügen
$sql = "INSERT INTO addresses (street, house_number, city, state, zip, country) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $street, $house_number, $city, $state, $zip, $country);
$stmt->execute();
$address_id = $stmt->insert_id; // Die ID der gerade eingefügten Adresse erhalten

// Servicepartner in die Datenbank einfügen
$sql = "INSERT INTO service_partners (name, tax_number, address_id, isInternal, user_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssiii", $name, $tax_number, $address_id, $isInternal, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Neuer Servicepartner erfolgreich hinzugefügt. <a href='/management/overview'>Zurück zur Übersicht</a>";
} else {
    echo "Fehler beim Hinzufügen des Servicepartners: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
