<?php
$title = "Management Dashboard";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/management/mgmt_navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Daten aus dem Formular
    $customer_id = $_POST['customer_id'];
    $name = $_POST['name'];
    $street = $_POST['street'];
    $house_number = $_POST['house_number'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    $telephone_number = $_POST['telephone_number'];
    $isVip = isset($_POST['isVip']) ? 1 : 0;

    // Kunden und Adresse aktualisieren
    $sql = "UPDATE customers SET name=?, telephone_number=?, isVip=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $name, $telephone_number, $isVip, $customer_id);
    $stmt->execute();

    $address_id = $_POST['address_id'];
    $sql = "UPDATE addresses SET street=?, house_number=?, city=?, state=?, zip=?, country=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $street, $house_number, $city, $state, $zip, $country, $address_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Kundendaten wurden erfolgreich aktualisiert.');</script>";
    } else {
        echo "<script>alert('Fehler beim Aktualisieren der Kundendaten: " . $conn->error . "');</script>";
    }

    $stmt->close();
} elseif (isset($_GET['delete'])) {
    // Kunden löschen
    $customer_id = $_GET['id'];
    $sql = "DELETE FROM customers WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Kunde erfolgreich gelöscht.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Fehler beim Löschen des Kunden: " . $conn->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
    exit();
} else {
    // Kundendaten abrufen
    $customer_id = $_GET['id'];
    $sql = "SELECT customers.id, customers.name, customers.telephone_number, customers.isVip, addresses.id AS address_id, addresses.street, addresses.house_number, addresses.city, addresses.state, addresses.zip, addresses.country 
            FROM customers 
            LEFT JOIN addresses ON customers.address_id = addresses.id 
            WHERE customers.id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $stmt->bind_result($id, $name, $telephone_number, $isVip, $address_id, $street, $house_number, $city, $state, $zip, $country);
    $stmt->fetch();
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Kundendaten bearbeiten</title>
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
</head>

<body>
    <h1>Kundendaten bearbeiten</h1>
    <form action="edit_customer.php" method="POST">
        <input type="hidden" name="customer_id" value="<?php echo $id; ?>">
        <input type="hidden" name="address_id" value="<?php echo $address_id; ?>">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br><br>

        <label for="street">Straße:</label>
        <input type="text" id="street" name="street" value="<?php echo $street; ?>" required><br><br>

        <label for="house_number">Hausnummer:</label>
        <input type="text" id="house_number" name="house_number" value="<?php echo $house_number; ?>"><br><br>

        <label for="city">Stadt:</label>
        <input type="text" id="city" name="city" value="<?php echo $city; ?>" required><br><br>

        <label for="state">Bundesland:</label>
        <input type="text" id="state" name="state" value="<?php echo $state; ?>"><br><br>

        <label for="zip">PLZ:</label>
        <input type="text" id="zip" name="zip" value="<?php echo $zip; ?>" required><br><br>

        <label for="country">Land:</label>
        <input type="text" id="country" name="country" value="<?php echo $country; ?>" required><br><br>

        <label for="telephone_number">Telefonnummer:</label>
        <input type="text" id="telephone_number" name="telephone_number" value="<?php echo $telephone_number; ?>" required><br><br>

        <label for="isVip">VIP Status:</label>
        <input type="checkbox" id="isVip" name="isVip" <?php echo $isVip ? 'checked' : ''; ?>><br><br>

        <input type="submit" value="Aktualisieren">
        <a href="edit_customer.php?id=<?php echo $id; ?>&delete=true" onclick="return confirm('Sind Sie sicher, dass Sie diesen Kunden löschen möchten?');">Löschen</a>
    </form>
</body>

</html>
