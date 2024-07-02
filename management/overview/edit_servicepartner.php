<?php
$title = "Management Dashboard";
$req_jquery = true;
include $_SERVER['DOCUMENT_ROOT'] . '/server/document_head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/server/database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/management/mgmt_navbar.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Daten aus dem Formular
    $sp_id = $_POST['sp_id'];
    $name = $_POST['name'];
    $tax_number = $_POST['tax_number'];
    $street = $_POST['street'];
    $house_number = $_POST['house_number'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    $isInternal = isset($_POST['isInternal']) ? 1 : 0;

    // Servicepartner und Adresse aktualisieren
    $sql = "UPDATE service_partners SET name=?, tax_number=?, isInternal=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $name, $tax_number, $isInternal, $sp_id);
    $stmt->execute();

    $address_id = $_POST['address_id'];
    $sql = "UPDATE addresses SET street=?, house_number=?, city=?, state=?, zip=?, country=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $street, $house_number, $city, $state, $zip, $country, $address_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Servicepartnerdaten wurden erfolgreich aktualisiert.');</script>";
    } else {
        echo "<script>alert('Fehler beim Aktualisieren der Servicepartnerdaten: " . $conn->error . "');</script>";
    }

    $stmt->close();
} elseif (isset($_GET['delete'])) {
    // Servicepartner löschen
    $sp_id = $_GET['id'];
    $sql = "DELETE FROM service_partners WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sp_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Servicepartner erfolgreich gelöscht.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Fehler beim Löschen des Servicepartners: " . $conn->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
    exit();
} else {
    // Servicepartnerdaten abrufen
    $sp_id = $_GET['id'];
    $sql = "SELECT service_partners.id, service_partners.name, service_partners.tax_number, service_partners.isInternal, addresses.id AS address_id, addresses.street, addresses.house_number, addresses.city, addresses.state, addresses.zip, addresses.country 
            FROM service_partners 
            LEFT JOIN addresses ON service_partners.address_id = addresses.id 
            WHERE service_partners.id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sp_id);
    $stmt->execute();
    $stmt->bind_result($id, $name, $tax_number, $isInternal, $address_id, $street, $house_number, $city, $state, $zip, $country);
    $stmt->fetch();
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Servicepartnerdaten bearbeiten</title>
    <style>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/style.css'; ?>
    </style>
</head>

<body>
    <h1>Servicepartnerdaten bearbeiten</h1>
    <form action="edit_servicepartner.php" method="POST">
        <input type="hidden" name="sp_id" value="<?php echo $id; ?>">
        <input type="hidden" name="address_id" value="<?php echo $address_id; ?>">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br><br>

        <label for="tax_number">Steuernummer:</label>
        <input type="text" id="tax_number" name="tax_number" value="<?php echo $tax_number; ?>" required><br><br>

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

        <label for="isInternal">Intern:</label>
        <input type="checkbox" id="isInternal" name="isInternal" <?php echo $isInternal ? 'checked' : ''; ?>><br><br>

        <input type="submit" value="Aktualisieren">
        <a href="edit_servicepartner.php?id=<?php echo $id; ?>&delete=true" onclick="return confirm('Sind Sie sicher, dass Sie diesen Servicepartner löschen möchten?');">Löschen</a>
    </form>
</body>

</html>
